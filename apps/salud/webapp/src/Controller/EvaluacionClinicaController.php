<?php

namespace SocialApp\Apps\Salud\Webapp\Controller;

use CarlosChininin\App\Infrastructure\Controller\WebAuthController;
use CarlosChininin\App\Infrastructure\Security\Permission;
use CarlosChininin\Util\Http\ParamFetcher;
use SocialApp\Apps\Salud\Webapp\Entity\EvaluacionClinica;
use SocialApp\Apps\Salud\Webapp\Form\EvaluacionClinicaType;
use SocialApp\Apps\Salud\Webapp\Manager\EvaluacionClinicaManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/evaluacion_clinica')]
class EvaluacionClinicaController extends WebAuthController
{
    public const BASE_ROUTE = 'evaluacion_clinica_index';

    #[Route(path: '/', name: 'evaluacion_clinica_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'evaluacion_clinica_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, EvaluacionClinicaManager $manager): Response
    {
        $this->denyAccess([Permission::LIST]);

        $paginator = $manager->paginate($page, ParamFetcher::fromRequestQuery($request));

        return $this->render(
            'evaluacion_clinica/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'evaluacion_clinica_export', methods: ['GET'])]
    public function export(Request $request, EvaluacionClinicaManager $manager): Response
    {
        $this->denyAccess([Permission::EXPORT]);

        $headers = [
            'isActive' => 'Activo',
        ];

        $items = $manager->dataExport(ParamFetcher::fromRequestQuery($request), true);

        return $manager->export($items, $headers, 'evaluacion_clinica');
    }

    #[Route(path: '/new', name: 'evaluacion_clinica_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EvaluacionClinicaManager $manager): Response
    {
        $this->denyAccess([Permission::NEW]);

        $evaluacionClinica = new EvaluacionClinica();
        $form = $this->createForm(EvaluacionClinicaType::class, $evaluacionClinica);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($evaluacionClinica)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('evaluacion_clinica_index');
        }

        return $this->render(
            'evaluacion_clinica/new.html.twig',
            [
                'evaluacion_clinica' => $evaluacionClinica,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'evaluacion_clinica_show', methods: ['GET'])]
    public function show(EvaluacionClinica $evaluacionClinica): Response
    {
        $this->denyAccess([Permission::SHOW], $evaluacionClinica);

        return $this->render('evaluacion_clinica/show.html.twig', ['evaluacion_clinica' => $evaluacionClinica]);
    }

    #[Route(path: '/{id}/edit', name: 'evaluacion_clinica_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EvaluacionClinica $evaluacionClinica, EvaluacionClinicaManager $manager): Response
    {
        $this->denyAccess([Permission::EDIT], $evaluacionClinica);

        $form = $this->createForm(EvaluacionClinicaType::class, $evaluacionClinica);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($evaluacionClinica)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('evaluacion_clinica_index', ['id' => $evaluacionClinica->getId()]);
        }

        return $this->render(
            'evaluacion_clinica/edit.html.twig',
            [
                'evaluacion_clinica' => $evaluacionClinica,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}/state', name: 'evaluacion_clinica_change_state', methods: ['POST'])]
    public function state(Request $request, EvaluacionClinica $evaluacionClinica, EvaluacionClinicaManager $manager): Response
    {
        $this->denyAccess([Permission::ENABLE, Permission::DISABLE], $evaluacionClinica);

        if ($this->isCsrfTokenValid('change_state'.$evaluacionClinica->getId(), $request->request->get('_token'))) {
            $evaluacionClinica->changeActive();
            if ($manager->save($evaluacionClinica)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('evaluacion_clinica_index');
    }

    #[Route(path: '/{id}/delete', name: 'evaluacion_clinica_delete', methods: ['POST'])]
    public function delete(Request $request, EvaluacionClinica $evaluacionClinica, EvaluacionClinicaManager $manager): Response
    {
        $this->denyAccess([Permission::DELETE], $evaluacionClinica);

        if ($this->isCsrfTokenValid('delete_forever'.$evaluacionClinica->getId(), $request->request->get('_token'))) {
            if ($manager->remove($evaluacionClinica)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('evaluacion_clinica_index');
    }
}
