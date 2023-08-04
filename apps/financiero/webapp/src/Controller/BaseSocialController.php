<?php

namespace SocialApp\Apps\Financiero\Webapp\Controller;

use CarlosChininin\App\Infrastructure\Controller\WebAuthController;
use CarlosChininin\App\Infrastructure\Security\Permission;
use CarlosChininin\Util\Http\ParamFetcher;
use SocialApp\Apps\Financiero\Webapp\Entity\BaseSocial;
use SocialApp\Apps\Financiero\Webapp\Form\BaseSocialType;
use SocialApp\Apps\Financiero\Webapp\Manager\BaseSocialManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/base_social')]
class BaseSocialController extends WebAuthController
{
    public const BASE_ROUTE = 'base_social_index';

    #[Route(path: '/', name: 'base_social_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'base_social_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, BaseSocialManager $manager): Response
    {
        $this->denyAccess([Permission::LIST]);

        $paginator = $manager->paginate($page, ParamFetcher::fromRequestQuery($request));

        return $this->render(
            'base_social/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'base_social_export', methods: ['GET'])]
    public function export(Request $request, BaseSocialManager $manager): Response
    {
        $this->denyAccess([Permission::EXPORT]);

        $headers = [
            'nombre' => 'Nombre',
            'localidad' => 'Localidad',
        ];

        $items = $manager->dataExport(ParamFetcher::fromRequestQuery($request), true);

        return $manager->export($items, $headers, 'base_social');
    }

    #[Route(path: '/new', name: 'base_social_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BaseSocialManager $manager): Response
    {
        $this->denyAccess([Permission::NEW]);

        $base_social = new BaseSocial();
        $form = $this->createForm(BaseSocialType::class, $base_social);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($base_social)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('base_social_index');
        }

        return $this->render(
            'base_social/new.html.twig',
            [
                'base_social' => $base_social,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'base_social_show', methods: ['GET'])]
    public function show(BaseSocial $base_social): Response
    {
        $this->denyAccess([Permission::SHOW], $base_social);

        return $this->render('base_social/show.html.twig', ['base_social' => $base_social]);
    }

    #[Route(path: '/{id}/edit', name: 'base_social_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BaseSocial $base_social, BaseSocialManager $manager): Response
    {
        $this->denyAccess([Permission::EDIT], $base_social);

        $form = $this->createForm(BaseSocialType::class, $base_social);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($base_social)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('base_social_index', ['id' => $base_social->getId()]);
        }

        return $this->render(
            'base_social/edit.html.twig',
            [
                'base_social' => $base_social,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}/state', name: 'base_social_change_state', methods: ['POST'])]
    public function state(Request $request, BaseSocial $base_social, BaseSocialManager $manager): Response
    {
        $this->denyAccess([Permission::ENABLE, Permission::DISABLE], $base_social);

        if ($this->isCsrfTokenValid('change_state'.$base_social->getId(), $request->request->get('_token'))) {
            $base_social->changeActive();
            if ($manager->save($base_social)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('base_social_index');
    }

    #[Route(path: '/{id}/delete', name: 'base_social_delete', methods: ['POST'])]
    public function delete(Request $request, BaseSocial $base_social, BaseSocialManager $manager): Response
    {
        $this->denyAccess([Permission::DELETE], $base_social);

        if ($this->isCsrfTokenValid('delete_forever'.$base_social->getId(), $request->request->get('_token'))) {
            if ($manager->remove($base_social)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('base_social_index');
    }

}
