<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Financiero\Webapp\Controller;

use CarlosChininin\App\Infrastructure\Controller\WebAuthController;
use CarlosChininin\App\Infrastructure\Security\Permission;
use CarlosChininin\Util\Http\ParamFetcher;
use SocialApp\Apps\Financiero\Webapp\Entity\Socio;
use SocialApp\Apps\Financiero\Webapp\Form\SocioType;
use SocialApp\Apps\Financiero\Webapp\Manager\SocioManager;
use SocialApp\Apps\Financiero\Webapp\Repository\ProyeccionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/socio')]
class SocioController extends WebAuthController
{
    public const BASE_ROUTE = 'socio_index';

    #[Route(path: '/', name: 'socio_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'socio_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, SocioManager $manager): Response
    {
        $this->denyAccess([Permission::LIST]);

        $paginator = $manager->paginate($page, ParamFetcher::fromRequestQuery($request));

        return $this->render(
            'socio/index.html.twig',
            [
                'paginator' => $paginator,
            ]
        );
    }

    #[Route(path: '/export', name: 'socio_export', methods: ['GET'])]
    public function export(Request $request, SocioManager $manager): Response
    {
        $this->denyAccess([Permission::EXPORT]);

        $headers = [
            'dni' => 'DNI',
            'apellidoPaterno' => 'Ape.Paterno',
            'apellidoMaterno' => 'Ape.Materno',
            'nombres' => 'Nombres',
//            'baseSocial'=>'Base Social',
            'telefono' => 'Telefono',
            'fechaNacimiento' => 'F.Nacimiento',
//            'estadoCivil' => 'Estado Civil',
//            'sexo' => 'Sexo',
        ];

        $items = $manager->dataExport(ParamFetcher::fromRequestQuery($request), true);

        return $manager->export($items, $headers, 'socio');
    }

    #[Route(path: '/new', name: 'socio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SocioManager $manager): Response
    {
        $this->denyAccess([Permission::NEW]);

        $socio = new Socio();
        $form = $this->createForm(SocioType::class, $socio);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($socio)) {
                $this->addFlash('success', 'Registro creado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('socio_index');
        }

        return $this->render(
            'socio/new.html.twig',
            [
                'socio' => $socio,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}', name: 'socio_show', methods: ['GET'])]
    public function show(Socio $socio, ProyeccionRepository $proyeccion): Response
    {
        $this->denyAccess([Permission::SHOW], $socio);
        $proyecciones = $proyeccion->getAllProyeccionBySocio($socio);
        $presentProyeccion = reset($proyecciones);

        return $this->render(
            'socio/show.html.twig',
            [
                'socio' => $socio,
                'proyeccion' => $presentProyeccion,
            ]
        );
    }

    #[Route(path: '/{id}/edit', name: 'socio_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Socio $socio, SocioManager $manager): Response
    {
        $this->denyAccess([Permission::EDIT], $socio);

        $form = $this->createForm(SocioType::class, $socio);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($socio)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('socio_index', ['id' => $socio->getId()]);
        }

        return $this->render(
            'socio/edit.html.twig',
            [
                'socio' => $socio,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route(path: '/{id}/state', name: 'socio_change_state', methods: ['POST'])]
    public function state(Request $request, Socio $socio, SocioManager $manager): Response
    {
        $this->denyAccess([Permission::ENABLE, Permission::DISABLE], $socio);

        if ($this->isCsrfTokenValid('change_state'.$socio->getId(), $request->request->get('_token'))) {
            $socio->changeActive();
            if ($manager->save($socio)) {
                $this->addFlash('success', 'Estado ha sido actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('socio_index');
    }

    #[Route(path: '/{id}/delete', name: 'socio_delete', methods: ['POST'])]
    public function delete(Request $request, Socio $socio, SocioManager $manager): Response
    {
        $this->denyAccess([Permission::DELETE], $socio);

        if ($this->isCsrfTokenValid('delete_forever'.$socio->getId(), $request->request->get('_token'))) {
            if ($manager->remove($socio)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('socio_index');
    }
}
