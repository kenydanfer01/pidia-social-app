<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Financiero\Webapp\Controller;

use CarlosChininin\App\Infrastructure\Controller\WebAuthController;
use CarlosChininin\App\Infrastructure\Security\Permission;
use CarlosChininin\Util\Http\ParamFetcher;
use SocialApp\Apps\Financiero\Webapp\Entity\ConfigMenu;
use SocialApp\Apps\Financiero\Webapp\Form\ConfigMenuType;
use SocialApp\Apps\Financiero\Webapp\Manager\ConfigMenuManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/admin/config_menu')]
final class ConfigMenuController extends WebAuthController
{
    public const BASE_ROUTE = 'config_menu_index';

    #[Route(path: '/', name: 'config_menu_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'config_menu_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, ConfigMenuManager $manager): Response
    {
        $this->denyAccess([Permission::LIST]);

        $paginator = $manager->paginate($page, ParamFetcher::fromRequestQuery($request));

        return $this->render(
            'config_menu/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'config_menu_export', methods: ['GET'])]
    public function export(Request $request, ConfigMenuManager $manager): Response
    {
        $this->denyAccess([Permission::EXPORT]);

        $headers = [
            'name' => 'Nombre',
            'route' => 'Ruta',
            'isActive' => 'Activo',
        ];

        $items = $manager->dataExport(ParamFetcher::fromRequestQuery($request), true);

        return $manager->export($items, $headers, 'menu_config');
    }

    #[Route(path: '/new', name: 'config_menu_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ConfigMenuManager $manager): Response
    {
        $this->denyAccess([Permission::NEW]);

        $configMenu = new ConfigMenu();
        $form = $this->createForm(ConfigMenuType::class, $configMenu);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($configMenu)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('config_menu_index');
        }

        return $this->render(
            'config_menu/new.html.twig',
            [
                'config_menu' => $configMenu,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'config_menu_show', methods: ['GET'])]
    public function show(ConfigMenu $configMenu): Response
    {
        $this->denyAccess([Permission::SHOW], $configMenu);

        return $this->render('config_menu/show.html.twig', ['config_menu' => $configMenu]);
    }

    #[Route(path: '/{id}/edit', name: 'config_menu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ConfigMenu $configMenu, ConfigMenuManager $manager): Response
    {
        $this->denyAccess([Permission::EDIT], $configMenu);

        $form = $this->createForm(ConfigMenuType::class, $configMenu);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($configMenu)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('config_menu_index', ['id' => $configMenu->getId()]);
        }

        return $this->render(
            'config_menu/edit.html.twig',
            [
                'config_menu' => $configMenu,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}/state', name: 'config_menu_change_state', methods: ['POST'])]
    public function state(Request $request, ConfigMenu $configMenu, ConfigMenuManager $manager): Response
    {
        $this->denyAccess([Permission::ENABLE, Permission::DISABLE], $configMenu);

        if ($this->isCsrfTokenValid('change_state'.$configMenu->getId(), $request->request->get('_token'))) {
            $configMenu->changeActive();
            if ($manager->save($configMenu)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('config_menu_index');
    }

    #[Route(path: '/{id}/delete', name: 'config_menu_delete', methods: ['POST'])]
    public function delete(Request $request, ConfigMenu $configMenu, ConfigMenuManager $manager): Response
    {
        $this->denyAccess([Permission::DELETE], $configMenu);

        if ($this->isCsrfTokenValid('delete_forever'.$configMenu->getId(), $request->request->get('_token'))) {
            if ($manager->remove($configMenu)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('config_menu_index');
    }
}
