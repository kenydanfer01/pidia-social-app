<?php

namespace SocialApp\Apps\Salud\Webapp\Controller;

use CarlosChininin\App\Infrastructure\Controller\WebAuthController;
use CarlosChininin\App\Infrastructure\Security\Permission;
use CarlosChininin\Util\Http\ParamFetcher;
use SocialApp\Apps\Salud\Webapp\Entity\ExamenAuxiliar;
use SocialApp\Apps\Salud\Webapp\Form\ExamenAuxiliarType;
use SocialApp\Apps\Salud\Webapp\Manager\ExamenAuxiliarManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/examen/auxiliar')]
class ExamenAuxiliarController extends WebAuthController
{
    public const BASE_ROUTE = 'examen_auxiliar_index';

    #[Route(path: '/', name: 'examen_auxiliar_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'examen_auxiliar_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, ExamenAuxiliarManager $manager): Response
    {
        $this->denyAccess([Permission::LIST]);

        $paginator = $manager->paginate($page, ParamFetcher::fromRequestQuery($request));

        return $this->render(
            'examen_auxiliar/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'examen_auxiliar_export', methods: ['GET'])]
    public function export(Request $request, ExamenAuxiliarManager $manager): Response
    {
        $this->denyAccess([Permission::EXPORT]);

        $headers = [
            'nombre' => 'Nombre',
        ];

        $items = $manager->dataExport(ParamFetcher::fromRequestQuery($request), true);

        return $manager->export($items, $headers, 'examen_auxiliar');
    }

    #[Route(path: '/new', name: 'examen_auxiliar_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ExamenAuxiliarManager $manager): Response
    {
        $this->denyAccess([Permission::NEW]);

        $examenAuxiliar = new ExamenAuxiliar();
        $form = $this->createForm(ExamenAuxiliarType::class, $examenAuxiliar);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($examenAuxiliar)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('examen_auxiliar_index');
        }

        return $this->render(
            'examen_auxiliar/new.html.twig',
            [
                'examen_auxiliar' => $examenAuxiliar,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'examen_auxiliar_show', methods: ['GET'])]
    public function show(ExamenAuxiliar $examenAuxiliar): Response
    {
        $this->denyAccess([Permission::SHOW], $examenAuxiliar);

        return $this->render('examen_auxiliar/show.html.twig', ['examen_auxiliar' => $examenAuxiliar]);
    }

    #[Route(path: '/{id}/edit', name: 'examen_auxiliar_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ExamenAuxiliar $examenAuxiliar, ExamenAuxiliarManager $manager): Response
    {
        $this->denyAccess([Permission::EDIT], $examenAuxiliar);

        $form = $this->createForm(ExamenAuxiliarType::class, $examenAuxiliar);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($examenAuxiliar)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('examen_auxiliar_index', ['id' => $examenAuxiliar->getId()]);
        }

        return $this->render(
            'examen_auxiliar/edit.html.twig',
            [
                'examen_auxiliar' => $examenAuxiliar,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}/state', name: 'examen_auxiliar_change_state', methods: ['POST'])]
    public function state(Request $request, ExamenAuxiliar $examenAuxiliar, ExamenAuxiliarManager $manager): Response
    {
        $this->denyAccess([Permission::ENABLE, Permission::DISABLE], $examenAuxiliar);

        if ($this->isCsrfTokenValid('change_state'.$examenAuxiliar->getId(), $request->request->get('_token'))) {
            $examenAuxiliar->changeActive();
            if ($manager->save($examenAuxiliar)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('examen_auxiliar_index');
    }

    #[Route(path: '/{id}/delete', name: 'examen_auxiliar_delete', methods: ['POST'])]
    public function delete(Request $request, ExamenAuxiliar $examenAuxiliar, ExamenAuxiliarManager $manager): Response
    {
        $this->denyAccess([Permission::DELETE], $examenAuxiliar);

        if ($this->isCsrfTokenValid('delete_forever'.$examenAuxiliar->getId(), $request->request->get('_token'))) {
            if ($manager->remove($examenAuxiliar)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('examen_auxiliar_index');
    }
}
