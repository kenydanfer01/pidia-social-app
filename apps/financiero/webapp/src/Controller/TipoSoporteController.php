<?php

namespace SocialApp\Apps\Financiero\Webapp\Controller;

use CarlosChininin\App\Infrastructure\Controller\WebAuthController;
use CarlosChininin\App\Infrastructure\Security\Permission;
use CarlosChininin\Util\Http\ParamFetcher;
use SocialApp\Apps\Financiero\Webapp\Entity\TipoSoporte;
use SocialApp\Apps\Financiero\Webapp\Form\TipoSoporteType;
use SocialApp\Apps\Financiero\Webapp\Manager\TipoSoporteManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/tipo_soporte')]
class TipoSoporteController extends WebAuthController
{
    public const BASE_ROUTE = 'tipo_soporte_index';

    #[Route(path: '/', name: 'tipo_soporte_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'tipo_soporte_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, TipoSoporteManager $manager): Response
    {
        $this->denyAccess([Permission::LIST]);

        $paginator = $manager->paginate($page, ParamFetcher::fromRequestQuery($request));

        return $this->render(
            'tipo_soporte/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'tipo_soporte_export', methods: ['GET'])]
    public function export(Request $request, TipoSoporteManager $manager): Response
    {
        $this->denyAccess([Permission::EXPORT]);

        $headers = [
            'nombre' => 'Nombre',
            'codigoCuenta' => 'Cod.Cuenta',
        ];

        $items = $manager->dataExport(ParamFetcher::fromRequestQuery($request), true);

        return $manager->export($items, $headers, 'tipo_soporte');
    }

    #[Route(path: '/new', name: 'tipo_soporte_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TipoSoporteManager $manager): Response
    {
        $this->denyAccess([Permission::NEW]);

        $tipo_soporte = new TipoSoporte();
        $form = $this->createForm(TipoSoporteType::class, $tipo_soporte);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($tipo_soporte)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('tipo_soporte_index');
        }

        return $this->render(
            'tipo_soporte/new.html.twig',
            [
                'tipo_soporte' => $tipo_soporte,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'tipo_soporte_show', methods: ['GET'])]
    public function show(TipoSoporte $tipo_soporte): Response
    {
        $this->denyAccess([Permission::SHOW], $tipo_soporte);

        return $this->render('tipo_soporte/show.html.twig', ['tipo_soporte' => $tipo_soporte]);
    }

    #[Route(path: '/{id}/edit', name: 'tipo_soporte_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TipoSoporte $tipo_soporte, TipoSoporteManager $manager): Response
    {
        $this->denyAccess([Permission::EDIT], $tipo_soporte);

        $form = $this->createForm(TipoSoporteType::class, $tipo_soporte);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($tipo_soporte)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('tipo_soporte_index', ['id' => $tipo_soporte->getId()]);
        }

        return $this->render(
            'tipo_soporte/edit.html.twig',
            [
                'tipo_soporte' => $tipo_soporte,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}/state', name: 'tipo_soporte_change_state', methods: ['POST'])]
    public function state(Request $request, TipoSoporte $tipo_soporte, TipoSoporteManager $manager): Response
    {
        $this->denyAccess([Permission::ENABLE, Permission::DISABLE], $tipo_soporte);

        if ($this->isCsrfTokenValid('change_state'.$tipo_soporte->getId(), $request->request->get('_token'))) {
            $tipo_soporte->changeActive();
            if ($manager->save($tipo_soporte)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('tipo_soporte_index');
    }

    #[Route(path: '/{id}/delete', name: 'tipo_soporte_delete', methods: ['POST'])]
    public function delete(Request $request, TipoSoporte $tipo_soporte, TipoSoporteManager $manager): Response
    {
        $this->denyAccess([Permission::DELETE], $tipo_soporte);

        if ($this->isCsrfTokenValid('delete_forever'.$tipo_soporte->getId(), $request->request->get('_token'))) {
            if ($manager->remove($tipo_soporte)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('tipo_soporte_index');
    }
}
