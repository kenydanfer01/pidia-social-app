<?php

namespace SocialApp\Apps\Salud\Webapp\Controller;

use CarlosChininin\App\Infrastructure\Controller\WebAuthController;
use CarlosChininin\App\Infrastructure\Security\Permission;
use CarlosChininin\Util\Http\ParamFetcher;
use SocialApp\Apps\Salud\Webapp\Entity\EnfermedadAsociada;
use SocialApp\Apps\Salud\Webapp\Form\EnfermedadAsociadaType;
use SocialApp\Apps\Salud\Webapp\Manager\EnfermedadAsociadaManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/enfermedad_asociada')]
class EnfermedadAsociadaController extends WebAuthController
{
    public const BASE_ROUTE = 'enfermedad_asociada_index';

    #[Route(path: '/', name: 'enfermedad_asociada_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'enfermedad_asociada_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, EnfermedadAsociadaManager $manager): Response
    {
        $this->denyAccess([Permission::LIST]);

        $paginator = $manager->paginate($page, ParamFetcher::fromRequestQuery($request));

        return $this->render(
            'enfermedad_asociada/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'enfermedad_asociada_export', methods: ['GET'])]
    public function export(Request $request, EnfermedadAsociadaManager $manager): Response
    {
        $this->denyAccess([Permission::EXPORT]);

        $headers = [
            'isActive' => 'Activo',
        ];

        $items = $manager->dataExport(ParamFetcher::fromRequestQuery($request), true);

        return $manager->export($items, $headers, 'enfermedad_asociada');
    }

    #[Route(path: '/new', name: 'enfermedad_asociada_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EnfermedadAsociadaManager $manager): Response
    {
        $this->denyAccess([Permission::NEW]);

        $enfermedadAsociada = new EnfermedadAsociada();
        $form = $this->createForm(EnfermedadAsociadaType::class, $enfermedadAsociada);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($enfermedadAsociada)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('enfermedad_asociada_index');
        }

        return $this->render(
            'enfermedad_asociada/new.html.twig',
            [
                'enfermedad_asociada' => $enfermedadAsociada,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'enfermedad_asociada_show', methods: ['GET'])]
    public function show(EnfermedadAsociada $enfermedadAsociada): Response
    {
        $this->denyAccess([Permission::SHOW], $enfermedadAsociada);

        return $this->render('enfermedad_asociada/show.html.twig', ['enfermedad_asociada' => $enfermedadAsociada]);
    }

    #[Route(path: '/{id}/edit', name: 'enfermedad_asociada_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EnfermedadAsociada $enfermedadAsociada, EnfermedadAsociadaManager $manager): Response
    {
        $this->denyAccess([Permission::EDIT], $enfermedadAsociada);

        $form = $this->createForm(EnfermedadAsociadaType::class, $enfermedadAsociada);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($enfermedadAsociada)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('enfermedad_asociada_index', ['id' => $enfermedadAsociada->getId()]);
        }

        return $this->render(
            'enfermedad_asociada/edit.html.twig',
            [
                'enfermedad_asociada' => $enfermedadAsociada,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}/state', name: 'enfermedad_asociada_change_state', methods: ['POST'])]
    public function state(Request $request, EnfermedadAsociada $enfermedadAsociada, EnfermedadAsociadaManager $manager): Response
    {
        $this->denyAccess([Permission::ENABLE, Permission::DISABLE], $enfermedadAsociada);

        if ($this->isCsrfTokenValid('change_state'.$enfermedadAsociada->getId(), $request->request->get('_token'))) {
            $enfermedadAsociada->changeActive();
            if ($manager->save($enfermedadAsociada)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('enfermedad_asociada_index');
    }

    #[Route(path: '/{id}/delete', name: 'enfermedad_asociada_delete', methods: ['POST'])]
    public function delete(Request $request, EnfermedadAsociada $enfermedadAsociada, EnfermedadAsociadaManager $manager): Response
    {
        $this->denyAccess([Permission::DELETE], $enfermedadAsociada);

        if ($this->isCsrfTokenValid('delete_forever'.$enfermedadAsociada->getId(), $request->request->get('_token'))) {
            if ($manager->remove($enfermedadAsociada)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('enfermedad_asociada_index');
    }
}
