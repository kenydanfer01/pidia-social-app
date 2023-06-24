<?php

namespace SocialApp\Apps\Salud\Webapp\Controller;

use CarlosChininin\ApiSearchPerson\SearchPersonService;
use CarlosChininin\App\Infrastructure\Controller\WebAuthController;
use CarlosChininin\App\Infrastructure\Security\Permission;
use CarlosChininin\Util\Http\ParamFetcher;
use SocialApp\Apps\Salud\Webapp\Entity\Paciente;
use SocialApp\Apps\Salud\Webapp\Form\PacienteType;
use SocialApp\Apps\Salud\Webapp\Manager\PacienteManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/paciente')]
class PacienteController extends WebAuthController
{
    public const BASE_ROUTE = 'paciente_index';

    #[Route(path: '/', name: 'paciente_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'paciente_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, PacienteManager $manager): Response
    {
        $this->denyAccess([Permission::LIST]);

        $paginator = $manager->paginate($page, ParamFetcher::fromRequestQuery($request));

        return $this->render(
            'paciente/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'paciente_export', methods: ['GET'])]
    public function export(Request $request, PacienteManager $manager): Response
    {
        $this->denyAccess([Permission::EXPORT]);

        $headers = [
            'name' => 'Nombre',
            'alias' => 'Alias',
            'isActive' => 'Activo',
        ];

        $items = $manager->dataExport(ParamFetcher::fromRequestQuery($request), true);

        return $manager->export($items, $headers, 'paciente');
    }

    #[Route(path: '/new', name: 'paciente_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PacienteManager $manager): Response
    {
        $this->denyAccess([Permission::NEW]);

        $paciente = new Paciente();
        $form = $this->createForm(PacienteType::class, $paciente);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($paciente)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('paciente_index');
        }

        return $this->render(
            'paciente/new.html.twig',
            [
                'paciente' => $paciente,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'paciente_show', methods: ['GET'])]
    public function show(Paciente $paciente): Response
    {
        $this->denyAccess([Permission::SHOW], $paciente);

        return $this->render('paciente/show.html.twig', ['paciente' => $paciente]);
    }

    #[Route(path: '/{id}/edit', name: 'paciente_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Paciente $paciente, PacienteManager $manager): Response
    {
        $this->denyAccess([Permission::EDIT], $paciente);

        $form = $this->createForm(PacienteType::class, $paciente);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($paciente)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('paciente_index', ['id' => $paciente->getId()]);
        }

        return $this->render(
            'paciente/edit.html.twig',
            [
                'paciente' => $paciente,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}/state', name: 'paciente_change_state', methods: ['POST'])]
    public function state(Request $request, Paciente $paciente, PacienteManager $manager): Response
    {
        $this->denyAccess([Permission::ENABLE, Permission::DISABLE], $paciente);

        if ($this->isCsrfTokenValid('change_state'.$paciente->getId(), $request->request->get('_token'))) {
            $paciente->changeActive();
            if ($manager->save($paciente)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('paciente_index');
    }

    #[Route(path: '/{id}/delete', name: 'paciente_delete', methods: ['POST'])]
    public function delete(Request $request, Paciente $paciente, PacienteManager $manager): Response
    {
        $this->denyAccess([Permission::DELETE], $paciente);

        if ($this->isCsrfTokenValid('delete_forever'.$paciente->getId(), $request->request->get('_token'))) {
            if ($manager->remove($paciente)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('paciente_index');
    }

    #[Route(path: '/search_dni', name: 'buscar_paciente_dni', methods: ['POST'])]
    public function searchPaciente(Request $request, SearchPersonService $personService): Response
    {
        $dni = $request->request->get('dni');
        $datos = $personService->dni($dni);

        return $this->json(['data' => $datos]);
    }
}
