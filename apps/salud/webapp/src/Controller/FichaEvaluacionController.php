<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Salud\Webapp\Controller;

use CarlosChininin\App\Infrastructure\Controller\WebAuthController;
use CarlosChininin\App\Infrastructure\Security\Permission;
use CarlosChininin\Util\Http\ParamFetcher;
use SocialApp\Apps\Salud\Webapp\Entity\FichaEvaluacion;
use SocialApp\Apps\Salud\Webapp\Form\FichaEvaluacionType;
use SocialApp\Apps\Salud\Webapp\Manager\FichaEvaluacionManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/ficha_evaluacion')]
class FichaEvaluacionController extends WebAuthController
{
    public const BASE_ROUTE = 'ficha_evaluacion_index';

    #[Route(path: '/', name: 'ficha_evaluacion_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'ficha_evaluacion_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, FichaEvaluacionManager $manager): Response
    {
        $this->denyAccess([Permission::LIST]);

        $paginator = $manager->paginate($page, ParamFetcher::fromRequestQuery($request));

        return $this->render(
            'ficha_evaluacion/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'ficha_evaluacion_export', methods: ['GET'])]
    public function export(Request $request, FichaEvaluacionManager $manager): Response
    {
        $this->denyAccess([Permission::EXPORT]);

        $headers = [
            'name' => 'Nombre',
            'alias' => 'Alias',
            'isActive' => 'Activo',
        ];

        $items = $manager->dataExport(ParamFetcher::fromRequestQuery($request), true);

        return $manager->export($items, $headers, 'ficha_evaluacion');
    }

    #[Route(path: '/new', name: 'ficha_evaluacion_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FichaEvaluacionManager $manager): Response
    {
        $this->denyAccess([Permission::NEW]);

        $fichaEvaluacion = new FichaEvaluacion();
        $form = $this->createForm(FichaEvaluacionType::class, $fichaEvaluacion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($fichaEvaluacion)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('ficha_evaluacion_index');
        }

        return $this->render(
            'ficha_evaluacion/new.html.twig',
            [
                'ficha_evaluacion' => $fichaEvaluacion,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'ficha_evaluacion_show', methods: ['GET'])]
    public function show(FichaEvaluacion $fichaEvaluacion): Response
    {
        $this->denyAccess([Permission::SHOW], $fichaEvaluacion);
        $paciente = $fichaEvaluacion->getPaciente();
        $evaluacionClinica = $fichaEvaluacion->getEvaluacionClinica();
        $examenFisico = $fichaEvaluacion->getExamenFisico();

        return $this->render(
            'ficha_evaluacion/show.html.twig',
            [
                'ficha_evaluacion' => $fichaEvaluacion,
                'paciente' => $paciente,
                'evaluacionClinica' => $evaluacionClinica,
                'examenFisico' => $examenFisico,
            ]
        );
    }

    #[Route(path: '/{id}/edit', name: 'ficha_evaluacion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FichaEvaluacion $fichaEvaluacion, FichaEvaluacionManager $manager): Response
    {
        $this->denyAccess([Permission::EDIT], $fichaEvaluacion);

        $form = $this->createForm(FichaEvaluacionType::class, $fichaEvaluacion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($fichaEvaluacion)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('ficha_evaluacion_index', ['id' => $fichaEvaluacion->getId()]);
        }

        return $this->render(
            'ficha_evaluacion/edit.html.twig',
            [
                'ficha_evaluacion' => $fichaEvaluacion,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}/state', name: 'ficha_evaluacion_change_state', methods: ['POST'])]
    public function state(Request $request, FichaEvaluacion $fichaEvaluacion, FichaEvaluacionManager $manager): Response
    {
        $this->denyAccess([Permission::ENABLE, Permission::DISABLE], $fichaEvaluacion);

        if ($this->isCsrfTokenValid('change_state'.$fichaEvaluacion->getId(), $request->request->get('_token'))) {
            $fichaEvaluacion->changeActive();
            if ($manager->save($fichaEvaluacion)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('ficha_evaluacion_index');
    }

    #[Route(path: '/{id}/delete', name: 'ficha_evaluacion_delete', methods: ['POST'])]
    public function delete(Request $request, FichaEvaluacion $fichaEvaluacion, FichaEvaluacionManager $manager): Response
    {
        $this->denyAccess([Permission::DELETE], $fichaEvaluacion);

        if ($this->isCsrfTokenValid('delete_forever'.$fichaEvaluacion->getId(), $request->request->get('_token'))) {
            if ($manager->remove($fichaEvaluacion)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('ficha_evaluacion_index');
    }
}
