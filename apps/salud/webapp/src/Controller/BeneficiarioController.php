<?php

namespace SocialApp\Apps\Salud\Webapp\Controller;

use CarlosChininin\ApiSearchPerson\SearchPersonService;
use CarlosChininin\App\Infrastructure\Controller\WebAuthController;
use CarlosChininin\App\Infrastructure\Security\Permission;
use CarlosChininin\Util\Http\ParamFetcher;
use SocialApp\Apps\Salud\Webapp\Entity\Beneficiario;
use SocialApp\Apps\Salud\Webapp\Form\BeneficiarioType;
use SocialApp\Apps\Salud\Webapp\Manager\BeneficiarioManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/beneficiario')]
class BeneficiarioController extends WebAuthController
{
    public const BASE_ROUTE = 'beneficiario_index';

    #[Route(path: '/', name: 'beneficiario_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'beneficiario_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, BeneficiarioManager $manager): Response
    {
        $this->denyAccess([Permission::LIST]);

        $paginator = $manager->paginate($page, ParamFetcher::fromRequestQuery($request));

        return $this->render(
            'beneficiario/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'beneficiario_export', methods: ['GET'])]
    public function export(Request $request, BeneficiarioManager $manager): Response
    {
        $this->denyAccess([Permission::EXPORT]);

        $headers = [
            'name' => 'Nombre',
            'alias' => 'Alias',
            'isActive' => 'Activo',
        ];

        $items = $manager->dataExport(ParamFetcher::fromRequestQuery($request), true);

        return $manager->export($items, $headers, 'beneficiario');
    }

    #[Route(path: '/new', name: 'beneficiario_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BeneficiarioManager $manager): Response
    {
        $this->denyAccess([Permission::NEW]);

        $beneficiario = new Beneficiario();
        $form = $this->createForm(BeneficiarioType::class, $beneficiario);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($beneficiario)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('beneficiario_index');
        }

        return $this->render(
            'beneficiario/new.html.twig',
            [
                'beneficiario' => $beneficiario,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'beneficiario_show', methods: ['GET'])]
    public function show(Beneficiario $beneficiario): Response
    {
        $this->denyAccess([Permission::SHOW], $beneficiario);

        return $this->render('beneficiario/show.html.twig', ['beneficiario' => $beneficiario]);
    }

    #[Route(path: '/{id}/edit', name: 'beneficiario_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Beneficiario $beneficiario, BeneficiarioManager $manager): Response
    {
        $this->denyAccess([Permission::EDIT], $beneficiario);

        $form = $this->createForm(BeneficiarioType::class, $beneficiario);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($beneficiario)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('beneficiario_index', ['id' => $beneficiario->getId()]);
        }

        return $this->render(
            'beneficiario/edit.html.twig',
            [
                'beneficiario' => $beneficiario,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}/state', name: 'beneficiario_change_state', methods: ['POST'])]
    public function state(Request $request, Beneficiario $beneficiario, BeneficiarioManager $manager): Response
    {
        $this->denyAccess([Permission::ENABLE, Permission::DISABLE], $beneficiario);

        if ($this->isCsrfTokenValid('change_state'.$beneficiario->getId(), $request->request->get('_token'))) {
            $beneficiario->changeActive();
            if ($manager->save($beneficiario)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('beneficiario_index');
    }

    #[Route(path: '/{id}/delete', name: 'beneficiario_delete', methods: ['POST'])]
    public function delete(Request $request, Beneficiario $beneficiario, BeneficiarioManager $manager): Response
    {
        $this->denyAccess([Permission::DELETE], $beneficiario);

        if ($this->isCsrfTokenValid('delete_forever'.$beneficiario->getId(), $request->request->get('_token'))) {
            if ($manager->remove($beneficiario)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('beneficiario_index');
    }

    #[Route(path: '/search_dni', name: 'buscar_beneficiario_dni', methods: ['POST'])]
    public function searchBeneficiario(Request $request, SearchPersonService $personService): Response
    {
        $dataRequest = $request->getContent();
        $decodedJson = json_decode($dataRequest, true, 512, JSON_THROW_ON_ERROR);

        $dni = $decodedJson['dni'];
        $datos = $personService->dni($dni);

        return $this->json(['data' => $datos]);
    }
}
