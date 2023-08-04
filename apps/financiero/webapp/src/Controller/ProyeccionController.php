<?php

namespace SocialApp\Apps\Financiero\Webapp\Controller;

use CarlosChininin\App\Infrastructure\Controller\WebAuthController;
use CarlosChininin\App\Infrastructure\Security\Permission;
use CarlosChininin\Util\Http\ParamFetcher;
use SocialApp\Apps\Financiero\Webapp\Entity\Proyeccion;
use SocialApp\Apps\Financiero\Webapp\Form\ProyeccionType;
use SocialApp\Apps\Financiero\Webapp\Manager\ProyeccionManager;
use SocialApp\Apps\Financiero\Webapp\Repository\ProyeccionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/proyeccion')]
class ProyeccionController extends WebAuthController
{
    public const BASE_ROUTE = 'proyeccion_index';

    #[Route(path: '/', name: 'proyeccion_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'proyeccion_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, ProyeccionManager $manager): Response
    {
        $this->denyAccess([Permission::LIST]);

        $paginator = $manager->paginate($page, ParamFetcher::fromRequestQuery($request));

        return $this->render(
            'proyeccion/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'proyeccion_export', methods: ['GET'])]
    public function export(Request $request, ProyeccionManager $manager): Response
    {
        $this->denyAccess([Permission::EXPORT]);

        $headers = [
//            'socio' => 'Socio',
            'anio' => 'Año',
            'quintales' => 'Quintales',
            'acopiadoQuintales' => 'Acopio Quintales',
            'aporte' => 'Aporte',
            'pagoAporte' => 'Pago Aporte',
        ];

        $items = $manager->dataExport(ParamFetcher::fromRequestQuery($request), true);

        return $manager->export($items, $headers, 'proyeccion');
    }

    #[Route(path: '/new', name: 'proyeccion_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProyeccionManager $manager): Response
    {
        $this->denyAccess([Permission::NEW]);

        $proyeccion = new Proyeccion();
        $form = $this->createForm(ProyeccionType::class, $proyeccion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($proyeccion)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('proyeccion_index');
        }

        return $this->render(
            'proyeccion/new.html.twig',
            [
                'proyeccion' => $proyeccion,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'proyeccion_show', methods: ['GET'])]
    public function show(Proyeccion $proyeccion): Response
    {
        $this->denyAccess([Permission::SHOW], $proyeccion);

        return $this->render('proyeccion/show.html.twig', ['proyeccion' => $proyeccion]);
    }

    #[Route(path: '/{id}/edit', name: 'proyeccion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Proyeccion $proyeccion, ProyeccionManager $manager): Response
    {
        $this->denyAccess([Permission::EDIT], $proyeccion);

        $form = $this->createForm(ProyeccionType::class, $proyeccion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($proyeccion)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('proyeccion_index', ['id' => $proyeccion->getId()]);
        }

        return $this->render(
            'proyeccion/edit.html.twig',
            [
                'proyeccion' => $proyeccion,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}/state', name: 'proyeccion_change_state', methods: ['POST'])]
    public function state(Request $request, Proyeccion $proyeccion, ProyeccionManager $manager): Response
    {
        $this->denyAccess([Permission::ENABLE, Permission::DISABLE], $proyeccion);

        if ($this->isCsrfTokenValid('change_state'.$proyeccion->getId(), $request->request->get('_token'))) {
            $proyeccion->changeActive();
            if ($manager->save($proyeccion)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('proyeccion_index');
    }

    #[Route(path: '/{id}/delete', name: 'proyeccion_delete', methods: ['POST'])]
    public function delete(Request $request, Proyeccion $proyeccion, ProyeccionManager $manager): Response
    {
        $this->denyAccess([Permission::DELETE], $proyeccion);

        if ($this->isCsrfTokenValid('delete_forever'.$proyeccion->getId(), $request->request->get('_token'))) {
            if ($manager->remove($proyeccion)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('proyeccion_index');
    }
}
