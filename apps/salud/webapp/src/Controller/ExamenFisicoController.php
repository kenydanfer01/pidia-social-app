<?php

namespace SocialApp\Apps\Salud\Webapp\Controller;

use CarlosChininin\App\Infrastructure\Controller\WebAuthController;
use CarlosChininin\App\Infrastructure\Security\Permission;
use CarlosChininin\Util\Http\ParamFetcher;
use SocialApp\Apps\Salud\Webapp\Entity\ExamenFisico;
use SocialApp\Apps\Salud\Webapp\Form\ExamenFisicoType;
use SocialApp\Apps\Salud\Webapp\Manager\ExamenFisicoManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/examen_fisico')]
class ExamenFisicoController extends WebAuthController
{
    public const BASE_ROUTE = 'examen_fisico_index';

    #[Route(path: '/', name: 'examen_fisico_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'examen_fisico_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, ExamenFisicoManager $manager): Response
    {
        $this->denyAccess([Permission::LIST]);

        $paginator = $manager->paginate($page, ParamFetcher::fromRequestQuery($request));

        return $this->render(
            'examen_fisico/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'examen_fisico_export', methods: ['GET'])]
    public function export(Request $request, ExamenFisicoManager $manager): Response
    {
        $this->denyAccess([Permission::EXPORT]);

        $headers = [
            'isActive' => 'Activo',
        ];

        $items = $manager->dataExport(ParamFetcher::fromRequestQuery($request), true);

        return $manager->export($items, $headers, 'examen_fisico');
    }

    #[Route(path: '/new', name: 'examen_fisico_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ExamenFisicoManager $manager): Response
    {
        $this->denyAccess([Permission::NEW]);

        $examenFisico = new ExamenFisico();
        $form = $this->createForm(ExamenFisicoType::class, $examenFisico);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($examenFisico)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('examen_fisico_index');
        }

        return $this->render(
            'examen_fisico/new.html.twig',
            [
                'examen_fisico' => $examenFisico,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'examen_fisico_show', methods: ['GET'])]
    public function show(ExamenFisico $examenFisico): Response
    {
        $this->denyAccess([Permission::SHOW], $examenFisico);

        return $this->render('examen_fisico/show.html.twig', ['examen_fisico' => $examenFisico]);
    }

    #[Route(path: '/{id}/edit', name: 'examen_fisico_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ExamenFisico $examenFisico, ExamenFisicoManager $manager): Response
    {
        $this->denyAccess([Permission::EDIT], $examenFisico);

        $form = $this->createForm(ExamenFisicoType::class, $examenFisico);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($examenFisico)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('examen_fisico_index', ['id' => $examenFisico->getId()]);
        }

        return $this->render(
            'examen_fisico/edit.html.twig',
            [
                'examen_fisico' => $examenFisico,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}/state', name: 'examen_fisico_change_state', methods: ['POST'])]
    public function state(Request $request, ExamenFisico $examenFisico, ExamenFisicoManager $manager): Response
    {
        $this->denyAccess([Permission::ENABLE, Permission::DISABLE], $examenFisico);

        if ($this->isCsrfTokenValid('change_state'.$examenFisico->getId(), $request->request->get('_token'))) {
            $examenFisico->changeActive();
            if ($manager->save($examenFisico)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('examen_fisico_index');
    }

    #[Route(path: '/{id}/delete', name: 'examen_fisico_delete', methods: ['POST'])]
    public function delete(Request $request, ExamenFisico $examenFisico, ExamenFisicoManager $manager): Response
    {
        $this->denyAccess([Permission::DELETE], $examenFisico);

        if ($this->isCsrfTokenValid('delete_forever'.$examenFisico->getId(), $request->request->get('_token'))) {
            if ($manager->remove($examenFisico)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('examen_fisico_index');
    }
}
