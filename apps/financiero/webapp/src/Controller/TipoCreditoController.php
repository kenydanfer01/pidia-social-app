<?php

namespace SocialApp\Apps\Financiero\Webapp\Controller;

use CarlosChininin\App\Infrastructure\Controller\WebAuthController;
use CarlosChininin\App\Infrastructure\Security\Permission;
use CarlosChininin\Util\Http\ParamFetcher;
use SocialApp\Apps\Financiero\Webapp\Entity\TipoCredito;
use SocialApp\Apps\Financiero\Webapp\Form\TipoCreditoType;
use SocialApp\Apps\Financiero\Webapp\Manager\TipoCreditoManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/tipo_credito')]
class TipoCreditoController extends WebAuthController
{
    public const BASE_ROUTE = 'tipo_credito_index';

    #[Route(path: '/', name: 'tipo_credito_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'tipo_credito_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, TipoCreditoManager $manager): Response
    {
        $this->denyAccess([Permission::LIST]);

        $paginator = $manager->paginate($page, ParamFetcher::fromRequestQuery($request));

        return $this->render(
            'tipo_credito/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'tipo_credito_export', methods: ['GET'])]
    public function export(Request $request, TipoCreditoManager $manager): Response
    {
        $this->denyAccess([Permission::EXPORT]);

        $headers = [
            'nombre' => 'Nombre',
            'codigoCuenta' => 'Cod.Cuenta',
        ];

        $items = $manager->dataExport(ParamFetcher::fromRequestQuery($request), true);

        return $manager->export($items, $headers, 'tipo_credito');
    }

    #[Route(path: '/new', name: 'tipo_credito_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TipoCreditoManager $manager): Response
    {
        $this->denyAccess([Permission::NEW]);

        $tipo_credito = new TipoCredito();
        $form = $this->createForm(TipoCreditoType::class, $tipo_credito);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($tipo_credito)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('tipo_credito_index');
        }

        return $this->render(
            'tipo_credito/new.html.twig',
            [
                'tipo_credito' => $tipo_credito,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'tipo_credito_show', methods: ['GET'])]
    public function show(TipoCredito $tipo_credito): Response
    {
        $this->denyAccess([Permission::SHOW], $tipo_credito);

        return $this->render('tipo_credito/show.html.twig', ['tipo_credito' => $tipo_credito]);
    }

    #[Route(path: '/{id}/edit', name: 'tipo_credito_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TipoCredito $tipo_credito, TipoCreditoManager $manager): Response
    {
        $this->denyAccess([Permission::EDIT], $tipo_credito);

        $form = $this->createForm(TipoCreditoType::class, $tipo_credito);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($tipo_credito)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('tipo_credito_index', ['id' => $tipo_credito->getId()]);
        }

        return $this->render(
            'tipo_credito/edit.html.twig',
            [
                'tipo_credito' => $tipo_credito,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}/state', name: 'tipo_credito_change_state', methods: ['POST'])]
    public function state(Request $request, TipoCredito $tipo_credito, TipoCreditoManager $manager): Response
    {
        $this->denyAccess([Permission::ENABLE, Permission::DISABLE], $tipo_credito);

        if ($this->isCsrfTokenValid('change_state'.$tipo_credito->getId(), $request->request->get('_token'))) {
            $tipo_credito->changeActive();
            if ($manager->save($tipo_credito)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('tipo_credito_index');
    }

    #[Route(path: '/{id}/delete', name: 'tipo_credito_delete', methods: ['POST'])]
    public function delete(Request $request, TipoCredito $tipo_credito, TipoCreditoManager $manager): Response
    {
        $this->denyAccess([Permission::DELETE], $tipo_credito);

        if ($this->isCsrfTokenValid('delete_forever'.$tipo_credito->getId(), $request->request->get('_token'))) {
            if ($manager->remove($tipo_credito)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('tipo_credito_index');
    }
}
