<?php

namespace SocialApp\Apps\Salud\Webapp\Controller;

use CarlosChininin\App\Infrastructure\Controller\WebAuthController;
use CarlosChininin\App\Infrastructure\Security\Permission;
use CarlosChininin\Util\Http\ParamFetcher;
use SocialApp\Apps\Salud\Webapp\Entity\EnfermedadesAsociadas;
use SocialApp\Apps\Salud\Webapp\Form\EnfermedadesAsociadasType;
use SocialApp\Apps\Salud\Webapp\Manager\EnfermedadesAsociadasManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/enfermedades_asociadas')]
class EnfermedadesAsociadasController extends WebAuthController
{
    public const BASE_ROUTE = 'enfermedades_asociadas_index';

    #[Route(path: '/', name: 'enfermedades_asociadas_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'enfermedades_asociadas_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, EnfermedadesAsociadasManager $manager): Response
    {
        $this->denyAccess([Permission::LIST]);

        $paginator = $manager->paginate($page, ParamFetcher::fromRequestQuery($request));

        return $this->render(
            'enfermedades_asociadas/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'enfermedades_asociadas_export', methods: ['GET'])]
    public function export(Request $request, EnfermedadesAsociadasManager $manager): Response
    {
        $this->denyAccess([Permission::EXPORT]);

        $headers = [
            'isActive' => 'Activo',
        ];

        $items = $manager->dataExport(ParamFetcher::fromRequestQuery($request), true);

        return $manager->export($items, $headers, 'enfermedades_asociadas');
    }

    #[Route(path: '/new', name: 'enfermedades_asociadas_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EnfermedadesAsociadasManager $manager): Response
    {
        $this->denyAccess([Permission::NEW]);

        $enfermedadesAsociadas = new EnfermedadesAsociadas();
        $form = $this->createForm(EnfermedadesAsociadasType::class, $enfermedadesAsociadas);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($enfermedadesAsociadas)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('enfermedades_asociadas_index');
        }

        return $this->render(
            'enfermedades_asociadas/new.html.twig',
            [
                'enfermedades_asociadas' => $enfermedadesAsociadas,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'enfermedades_asociadas_show', methods: ['GET'])]
    public function show(EnfermedadesAsociadas $enfermedadesAsociadas): Response
    {
        $this->denyAccess([Permission::SHOW], $enfermedadesAsociadas);

        return $this->render('enfermedades_asociadas/show.html.twig', ['enfermedades_asociadas' => $enfermedadesAsociadas]);
    }

    #[Route(path: '/{id}/edit', name: 'enfermedades_asociadas_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EnfermedadesAsociadas $enfermedadesAsociadas, EnfermedadesAsociadasManager $manager): Response
    {
        $this->denyAccess([Permission::EDIT], $enfermedadesAsociadas);

        $form = $this->createForm(EnfermedadesAsociadasType::class, $enfermedadesAsociadas);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($enfermedadesAsociadas)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('enfermedades_asociadas_index', ['id' => $enfermedadesAsociadas->getId()]);
        }

        return $this->render(
            'enfermedades_asociadas/edit.html.twig',
            [
                'enfermedades_asociadas' => $enfermedadesAsociadas,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}/state', name: 'enfermedades_asociadas_change_state', methods: ['POST'])]
    public function state(Request $request, EnfermedadesAsociadas $enfermedadesAsociadas, EnfermedadesAsociadasManager $manager): Response
    {
        $this->denyAccess([Permission::ENABLE, Permission::DISABLE], $enfermedadesAsociadas);

        if ($this->isCsrfTokenValid('change_state'.$enfermedadesAsociadas->getId(), $request->request->get('_token'))) {
            $enfermedadesAsociadas->changeActive();
            if ($manager->save($enfermedadesAsociadas)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('enfermedades_asociadas_index');
    }

    #[Route(path: '/{id}/delete', name: 'enfermedades_asociadas_delete', methods: ['POST'])]
    public function delete(Request $request, EnfermedadesAsociadas $enfermedadesAsociadas, EnfermedadesAsociadasManager $manager): Response
    {
        $this->denyAccess([Permission::DELETE], $enfermedadesAsociadas);

        if ($this->isCsrfTokenValid('delete_forever'.$enfermedadesAsociadas->getId(), $request->request->get('_token'))) {
            if ($manager->remove($enfermedadesAsociadas)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('enfermedades_asociadas_index');
    }
}
