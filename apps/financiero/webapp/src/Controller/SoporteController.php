<?php

namespace SocialApp\Apps\Financiero\Webapp\Controller;

use CarlosChininin\App\Infrastructure\Controller\WebAuthController;
use CarlosChininin\App\Infrastructure\Security\Permission;
use CarlosChininin\Util\Http\ParamFetcher;
use SocialApp\Apps\Financiero\Webapp\Entity\Soporte;
use SocialApp\Apps\Financiero\Webapp\Entity\Pago;
use SocialApp\Apps\Financiero\Webapp\Filter\Dto\SoporteFilterDto;
use SocialApp\Apps\Financiero\Webapp\Filter\Dto\EditPagoDto;
use SocialApp\Apps\Financiero\Webapp\Form\SoporteFilterType;
use SocialApp\Apps\Financiero\Webapp\Form\SoporteType;
use SocialApp\Apps\Financiero\Webapp\Form\EditPagoType;
use SocialApp\Apps\Financiero\Webapp\Form\PagoType;
use SocialApp\Apps\Financiero\Webapp\Manager\SoporteManager;
use SocialApp\Apps\Financiero\Webapp\Service\soporte\GetPaginatedSoportes;
use SocialApp\Apps\Financiero\Webapp\Service\Pago\EditarPagoService;
use SocialApp\Apps\Financiero\Webapp\Service\Pago\GetAllPagosBySoporteService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/soporte')]
class SoporteController extends WebAuthController
{
    public const BASE_ROUTE = 'soporte_index';

    #[Route(path: '/', name: 'soporte_index', defaults: ['page' => '1'], methods: ['GET','POST'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'soporte_index_paginated', methods: ['GET','POST'])]
    public function index(Request $request, int $page, GetPaginatedSoportes $getPaginatedSoportes, SoporteManager $manager): Response
    {
        $this->denyAccess([Permission::LIST]);
        $filterDto = new SoporteFilterDto();
        $filterDto->page = $page;
        $filterForm = $this->createForm(SoporteFilterType::class, $filterDto);
        $filterForm->handleRequest($request);
        $paginator = $getPaginatedSoportes->execute($filterDto);
//        $paginator = $manager->paginate($page, ParamFetcher::fromRequestQuery($request));

        return $this->render(
            'soporte/index.html.twig',
            [
                'paginator' => $paginator,
                'formFilter' => $filterForm->createView(),
            ]
        );
    }

    #[Route(path: '/export', name: 'soporte_export', methods: ['GET'])]
    public function export(Request $request, SoporteManager $manager): Response
    {
        $this->denyAccess([Permission::EXPORT]);

        $headers = [
//            'socio' => 'Socio',
//            'tipoSoporte' => 'Tip.Soporte',
            'monto' => 'Monto',
            'amortizacion' => 'Amortizacion',
        ];

        $items = $manager->dataExport(ParamFetcher::fromRequestQuery($request), true);

        return $manager->export($items, $headers, 'soporte');
    }

    #[Route(path: '/new', name: 'soporte_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SoporteManager $manager): Response
    {
        $this->denyAccess([Permission::NEW]);

        $soporte = new Soporte();
        $form = $this->createForm(SoporteType::class, $soporte);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($soporte)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('soporte_index');
        }

        return $this->render(
            'soporte/new.html.twig',
            [
                'soporte' => $soporte,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'soporte_show', methods: ['GET','POST'])]
    public function show(
        Soporte                     $soporte,
        Request                     $request,
        GetAllPagosBySoporteService $getAllPagosBySoporteService,
        EditarPagoService           $editarPagoService,
    ): Response
    {
        $soporteId = $request->get('id');
        $dataPagosBySoporte =$getAllPagosBySoporteService->execute($soporteId);

        $this->denyAccess([Permission::SHOW], $soporte);

        $pago = new Pago();
        $formPago = $this->createForm(PagoType::class, $pago);

        $editPago = new EditPagoDto();
        $formEditPago = $this->createForm(EditPagoType::class, $editPago);

        $formEditPago->handleRequest($request);

        if($formEditPago->isSubmitted() && $formEditPago->isValid()){
            $formData = $formEditPago->getData();
            $idPago=$formData->getIdPago();
            $ePago=$formData->getEPago();
            $eFechaPago=$formData->getFechaPagoEdit();

            $editarPagoService->execute($idPago,$ePago,$eFechaPago,$soporte);

            $this->addFlash('success', 'El pago a sido actualizado con exito.');
            return $this->redirectToRoute('soporte_show', ['id' => $soporteId]);
        }

        return $this->render('soporte/show.html.twig', [
            'soporte' => $soporte,
            'dataPagosBySoporte'=>(empty($dataPagosBySoporte))?null:$dataPagosBySoporte,
            'formPago' => $formPago->createView(),
            'formEditPago'=>$formEditPago->createView(),
        ]);
    }

    #[Route(path: '/{id}/edit', name: 'soporte_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Soporte $soporte, SoporteManager $manager): Response
    {
        $this->denyAccess([Permission::EDIT], $soporte);

        $form = $this->createForm(SoporteType::class, $soporte);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($soporte)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('soporte_index', ['id' => $soporte->getId()]);
        }

        return $this->render(
            'soporte/edit.html.twig',
            [
                'soporte' => $soporte,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}/state', name: 'soporte_change_state', methods: ['POST'])]
    public function state(Request $request, Soporte $soporte, SoporteManager $manager): Response
    {
        $this->denyAccess([Permission::ENABLE, Permission::DISABLE], $soporte);

        if ($this->isCsrfTokenValid('change_state'.$soporte->getId(), $request->request->get('_token'))) {
            $soporte->changeActive();
            if ($manager->save($soporte)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('soporte_index');
    }

    #[Route(path: '/{id}/delete', name: 'soporte_delete', methods: ['POST'])]
    public function delete(Request $request, Soporte $soporte, SoporteManager $manager): Response
    {
        $this->denyAccess([Permission::DELETE], $soporte);

        if ($this->isCsrfTokenValid('delete_forever'.$soporte->getId(), $request->request->get('_token'))) {
            if ($manager->remove($soporte)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('soporte_index');
    }
}
