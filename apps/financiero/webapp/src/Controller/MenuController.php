<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Financiero\Webapp\Controller;

use CarlosChininin\App\Infrastructure\Controller\WebAuthController;
use CarlosChininin\App\Infrastructure\Security\Menu\MenuBuilder;
use CarlosChininin\App\Infrastructure\Security\Permission;
use CarlosChininin\Util\Http\ParamFetcher;
use SocialApp\Apps\Financiero\Webapp\Cache\MenuCache;
use SocialApp\Apps\Financiero\Webapp\Entity\Menu;
use SocialApp\Apps\Financiero\Webapp\Form\MenuType;
use SocialApp\Apps\Financiero\Webapp\Manager\MenuManager;
use SocialApp\Apps\Financiero\Webapp\Repository\MenuRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/admin/menu')]
class MenuController extends WebAuthController
{
    public const BASE_ROUTE = 'menu_index';

    #[Route(path: '/', name: 'menu_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'menu_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, MenuManager $manager): Response
    {
        $this->denyAccess([Permission::LIST]);

        $paginator = $manager->paginate($page, ParamFetcher::fromRequestQuery($request));

        return $this->render(
            'menu/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'menu_export', methods: ['GET'])]
    public function export(Request $request, MenuManager $manager): Response
    {
        $this->denyAccess([Permission::EXPORT]);

        $headers = [
            'parent.name' => 'Padre',
            'name' => 'Nombre',
            'route' => 'Ruta',
            'icon' => 'Icono',
            'ranking' => 'Orden',
            'isActive' => 'Activo',
        ];

        $items = $manager->dataExport(ParamFetcher::fromRequestQuery($request), true);

        return $manager->export($items, $headers, 'menu');
    }

    #[Route(path: '/new', name: 'menu_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MenuManager $manager, MenuCache $cache): Response
    {
        $this->denyAccess([Permission::NEW]);

        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($menu)) {
                $cache->update();
                $this->messageSuccess('Registro creado!!!');

                return $this->redirectToRoute('menu_index', [], Response::HTTP_SEE_OTHER);
            }

            $this->addErrors($manager->errors());
        }

        return $this->render(
            'menu/new.html.twig',
            [
                'menu' => $menu,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'menu_show', methods: ['GET'])]
    public function show(Menu $menu): Response
    {
        $this->denyAccess([Permission::SHOW], $menu);

        return $this->render('menu/show.html.twig', ['menu' => $menu]);
    }

    #[Route(path: '/{id}/edit', name: 'menu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Menu $menu, MenuManager $manager, MenuCache $cache): Response
    {
        $this->denyAccess([Permission::EDIT], $menu);

        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($menu)) {
                $cache->update();
                $this->messageSuccess('Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('menu_index', ['id' => $menu->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render(
            'menu/edit.html.twig',
            [
                'menu' => $menu,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}/state', name: 'menu_change_state', methods: ['POST'])]
    public function state(Request $request, Menu $menu, MenuManager $manager, MenuCache $cache): Response
    {
        $this->denyAccess([Permission::ENABLE, Permission::DISABLE], $menu);

        if ($this->isCsrfTokenValid('change_state'.$menu->getId(), $request->request->get('_token'))) {
            $menu->changeActive();
            if ($manager->save($menu)) {
                $cache->update();
                $this->messageSuccess('Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('menu_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route(path: '/{id}/delete', name: 'menu_delete', methods: ['POST'])]
    public function delete(Request $request, Menu $menu, MenuManager $manager, MenuCache $cache): Response
    {
        $this->denyAccess([Permission::DELETE], $menu);

        if ($this->isCsrfTokenValid('delete_forever'.$menu->getId(), $request->request->get('_token'))) {
            if ($manager->remove($menu)) {
                $cache->update();
                $this->messageWarning('Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('menu_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/menu_build', name: 'menu_build', methods: ['GET'])]
    public function buildMenu(string $menuSelected, MenuRepository $menuRepository, MenuBuilder $menuBuilder, MenuCache $menuCache): Response
    {
        $content = $menuCache->menus($menuSelected, function () use ($menuRepository, $menuBuilder, $menuSelected) {
            $menus = $menuRepository->searchAllActiveWithOrder();

            return $this->renderView('@App/theme1/menu/menu.html.twig', [
                'menus' => $menuBuilder->execute($menus, $menuSelected),
                'menuSelected' => $menuSelected,
            ]);
        });

        return new Response($content);
    }
}
