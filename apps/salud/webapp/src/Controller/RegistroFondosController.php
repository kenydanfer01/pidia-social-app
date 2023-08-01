<?php

namespace SocialApp\Apps\Salud\Webapp\Controller;

use CarlosChininin\App\Infrastructure\Controller\WebAuthController;
use CarlosChininin\App\Infrastructure\Security\Permission;
use CarlosChininin\Util\Http\ParamFetcher;
use SocialApp\Apps\Salud\Webapp\Entity\RegistroFondos;
use SocialApp\Apps\Salud\Webapp\Form\RegistroFondosType;
use SocialApp\Apps\Salud\Webapp\Manager\RegistroFondosManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/registro_fondos')]
class RegistroFondosController extends WebAuthController
{
    public const BASE_ROUTE = 'registro_fondos_index';

    #[Route(path: '/', name: 'registro_fondos_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'registro_fondos_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, RegistroFondosManager $manager): Response
    {
        $this->denyAccess([Permission::LIST]);

        $paginator = $manager->paginate($page, ParamFetcher::fromRequestQuery($request));

        return $this->render(
            'registro_fondos/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'registro_fondos_export', methods: ['GET'])]
    public function export(Request $request, RegistroFondosManager $manager): Response
    {
        $this->denyAccess([Permission::EXPORT]);

        $headers = [
            'name' => 'Nombre',
            'alias' => 'Alias',
            'isActive' => 'Activo',
        ];

        $items = $manager->dataExport(ParamFetcher::fromRequestQuery($request), true);

        return $manager->export($items, $headers, 'registro_fondos');
    }

    #[Route(path: '/new', name: 'registro_fondos_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RegistroFondosManager $manager): Response
    {
        $this->denyAccess([Permission::NEW]);

        $registroFondos = new RegistroFondos();
        $form = $this->createForm(RegistroFondosType::class, $registroFondos);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($registroFondos)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('registro_fondos_index');
        }

        return $this->render(
            'registro_fondos/new.html.twig',
            [
                'registro_fondos' => $registroFondos,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'registro_fondos_show', methods: ['GET'])]
    public function show(RegistroFondos $registroFondos): Response
    {
        $this->denyAccess([Permission::SHOW], $registroFondos);

        return $this->render(
            'registro_fondos/show.html.twig',
            [
                'registro_fondos' => $registroFondos,

            ]
        );
    }

    #[Route(path: '/{id}/edit', name: 'registro_fondos_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RegistroFondos $registroFondos, RegistroFondosManager $manager): Response
    {
        $this->denyAccess([Permission::EDIT], $registroFondos);

        $form = $this->createForm(RegistroFondosType::class, $registroFondos);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($registroFondos)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('registro_fondos_index', ['id' => $registroFondos->getId()]);
        }

        return $this->render(
            'registro_fondos/edit.html.twig',
            [
                'registro_fondos' => $registroFondos,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}/state', name: 'registro_fondos_change_state', methods: ['POST'])]
    public function state(Request $request, RegistroFondos $registroFondos, RegistroFondosManager $manager): Response
    {
        $this->denyAccess([Permission::ENABLE, Permission::DISABLE], $registroFondos);

        if ($this->isCsrfTokenValid('change_state'.$registroFondos->getId(), $request->request->get('_token'))) {
            $registroFondos->changeActive();
            if ($manager->save($registroFondos)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('registro_fondos_index');
    }

    #[Route(path: '/{id}/delete', name: 'registro_fondos_delete', methods: ['POST'])]
    public function delete(Request $request, RegistroFondos $registroFondos, RegistroFondosManager $manager): Response
    {
        $this->denyAccess([Permission::DELETE], $registroFondos);

        if ($this->isCsrfTokenValid('delete_forever'.$registroFondos->getId(), $request->request->get('_token'))) {
            if ($manager->remove($registroFondos)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('registro_fondos_index');
    }
}
