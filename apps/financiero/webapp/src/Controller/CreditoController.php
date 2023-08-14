<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Financiero\Webapp\Controller;

use CarlosChininin\App\Infrastructure\Controller\WebAuthController;
use CarlosChininin\App\Infrastructure\Security\Permission;
use CarlosChininin\Util\Http\ParamFetcher;
use SocialApp\Apps\Financiero\Webapp\Entity\Credito;
use SocialApp\Apps\Financiero\Webapp\Entity\Pago;
use SocialApp\Apps\Financiero\Webapp\Filter\Dto\CreditoFilterDto;
use SocialApp\Apps\Financiero\Webapp\Filter\Dto\EditPagoDto;
use SocialApp\Apps\Financiero\Webapp\Form\CreditoFilterType;
use SocialApp\Apps\Financiero\Webapp\Form\CreditoType;
use SocialApp\Apps\Financiero\Webapp\Form\EditPagoType;
use SocialApp\Apps\Financiero\Webapp\Form\PagoType;
use SocialApp\Apps\Financiero\Webapp\Manager\CreditoManager;
use SocialApp\Apps\Financiero\Webapp\Service\credito\GetPaginatedCreditos;
use SocialApp\Apps\Financiero\Webapp\Service\Pago\EditarPagoService;
use SocialApp\Apps\Financiero\Webapp\Service\Pago\GetAllPagosByCreditoService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/credito')]
class CreditoController extends WebAuthController
{
    public const BASE_ROUTE = 'credito_index';

    #[Route(path: '/', name: 'credito_index', defaults: ['page' => '1'], methods: ['GET', 'POST'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'credito_index_paginated', methods: ['GET', 'POST'])]
    public function index(Request $request, int $page, GetPaginatedCreditos $getPaginatedCreditos, CreditoManager $manager): Response
    {
        $this->denyAccess([Permission::LIST]);
        $filterDto = new CreditoFilterDto();
        $filterDto->page = $page;
        $filterForm = $this->createForm(CreditoFilterType::class, $filterDto);
        $filterForm->handleRequest($request);
        $paginator = $getPaginatedCreditos->execute($filterDto);
//        $paginator = $manager->paginate($page, ParamFetcher::fromRequestQuery($request));

        return $this->render(
            'credito/index.html.twig',
            [
                'paginator' => $paginator,
                'formFilter' => $filterForm->createView(),
            ]
        );
    }

    #[Route(path: '/export', name: 'credito_export', methods: ['GET'])]
    public function export(Request $request, CreditoManager $manager): Response
    {
        $this->denyAccess([Permission::EXPORT]);

        $headers = [
//            'socio' => 'Socio',
//            'tipoCredito' => 'Tip.Credito',
            'monto' => 'Monto',
            'amortizacion' => 'Amortizacion',
        ];

        $items = $manager->dataExport(ParamFetcher::fromRequestQuery($request), true);

        return $manager->export($items, $headers, 'credito');
    }

    #[Route(path: '/new', name: 'credito_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CreditoManager $manager): Response
    {
        $this->denyAccess([Permission::NEW]);

        $credito = new Credito();
        $form = $this->createForm(CreditoType::class, $credito);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($credito)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('credito_index');
        }

        return $this->render(
            'credito/new.html.twig',
            [
                'credito' => $credito,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'credito_show', methods: ['GET', 'POST'])]
    public function show(
        Credito $credito,
        Request $request,
        GetAllPagosByCreditoService $getAllPagosByCreditoService,
        EditarPagoService $editarPagoService,
    ): Response {
        $creditoId = $request->get('id');
        $dataPagosByCredito = $getAllPagosByCreditoService->execute($creditoId);

        $this->denyAccess([Permission::SHOW], $credito);

        $pago = new Pago();
        $formPago = $this->createForm(PagoType::class, $pago);

        $editPago = new EditPagoDto();
        $formEditPago = $this->createForm(EditPagoType::class, $editPago);

        return $this->render('credito/show.html.twig', [
            'credito' => $credito,
            'dataPagosByCredito' => (empty($dataPagosByCredito)) ? null : $dataPagosByCredito,
            'formPago' => $formPago->createView(),
            'formEditPago' => $formEditPago->createView(),
        ]);
    }

    #[Route(path: '/{id}/edit', name: 'credito_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Credito $credito, CreditoManager $manager): Response
    {
        $this->denyAccess([Permission::EDIT], $credito);

        $form = $this->createForm(CreditoType::class, $credito);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($credito)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('credito_index', ['id' => $credito->getId()]);
        }

        return $this->render(
            'credito/edit.html.twig',
            [
                'credito' => $credito,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}/state', name: 'credito_change_state', methods: ['POST'])]
    public function state(Request $request, Credito $credito, CreditoManager $manager): Response
    {
        $this->denyAccess([Permission::ENABLE, Permission::DISABLE], $credito);

        if ($this->isCsrfTokenValid('change_state'.$credito->getId(), $request->request->get('_token'))) {
            $credito->changeActive();
            if ($manager->save($credito)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('credito_index');
    }

    #[Route(path: '/{id}/delete', name: 'credito_delete', methods: ['POST'])]
    public function delete(Request $request, Credito $credito, CreditoManager $manager): Response
    {
        $this->denyAccess([Permission::DELETE], $credito);

        if ($this->isCsrfTokenValid('delete_forever'.$credito->getId(), $request->request->get('_token'))) {
            if ($manager->remove($credito)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('credito_index');
    }
}
