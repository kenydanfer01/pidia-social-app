<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Financiero\Webapp\Controller;

use CarlosChininin\App\Infrastructure\Controller\WebAuthController;
use CarlosChininin\App\Infrastructure\Security\Permission;
use CarlosChininin\Util\Http\ParamFetcher;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use SocialApp\Apps\Financiero\Webapp\Entity\Usuario;
use SocialApp\Apps\Financiero\Webapp\Form\UsuarioType;
use SocialApp\Apps\Financiero\Webapp\Manager\UsuarioManager;
use SocialApp\Apps\Financiero\Webapp\Security\PasswordSecurity;
use Symfony\Component\Config\Definition\Exception\DuplicateKeyException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/admin/usuario')]
final class UsuarioController extends WebAuthController
{
    public const BASE_ROUTE = 'usuario_index';

    #[Route(path: '/', name: 'usuario_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route(path: '/page/{page<[1-9]\d*>}', name: 'usuario_index_paginated', methods: ['GET'])]
    public function index(Request $request, int $page, UsuarioManager $manager): Response
    {
        $this->denyAccess([Permission::LIST]);

        $paginator = $manager->paginate($page, ParamFetcher::fromRequestQuery($request));

        return $this->render('usuario/index.html.twig', [
            'paginator' => $paginator,
        ]);
    }

    #[Route(path: '/export', name: 'usuario_export', methods: ['GET'])]
    public function export(Request $request, UsuarioManager $manager): Response
    {
        $this->denyAccess([Permission::EXPORT]);

        $headers = [
            'username' => 'Usuario',
            'fullName' => 'Nombres',
            'email' => 'Correo',
            'usuarioRoles.name' => 'Roles',
            'isActive' => 'Activo',
        ];

        $usuarios = $manager->dataExport(ParamFetcher::fromRequestQuery($request), true);

        return $manager->export($usuarios, $headers, 'usuario');
    }

    #[Route(path: '/new', name: 'usuario_new', methods: 'GET|POST')]
    public function new(Request $request, PasswordSecurity $authPassword, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccess([Permission::NEW]);

        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $usuario->setOwner($this->getUser());
            try {
                $usuario->setPassword($authPassword->encrypt($usuario, $usuario->getPassword()));
                $entityManager->persist($usuario);
                $entityManager->flush();

                return $this->redirectToRoute('usuario_index');
            } catch (DuplicateKeyException) {
                $this->addFlash('danger', 'Existe un email o usuario repetido');
            } catch (Exception) {
                $this->addFlash('danger', 'Se ha producido un error');
            }
        }

        return $this->render('usuario/new.html.twig', [
            'usuario' => $usuario,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/{id}', name: 'usuario_show', methods: 'GET')]
    public function show(Usuario $usuario): Response
    {
        $this->denyAccess([Permission::SHOW], $usuario);

        return $this->render('usuario/show.html.twig', ['usuario' => $usuario]);
    }

    #[Route(path: '/{id}/edit', name: 'usuario_edit', methods: 'GET|POST')]
    public function edit(
        Request $request,
        Usuario $usuario,
        PasswordSecurity $authPassword,
        EntityManagerInterface $entityManager,
    ): Response {
        $this->denyAccess([Permission::EDIT], $usuario);

        $passwordOriginal = $usuario->getPassword();
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (null !== $usuario->getPassword() && '' !== $usuario->getPassword()) {
                $usuario->setPassword($authPassword->encrypt(Usuario::class, $usuario->getPassword()));
            } else {
                $usuario->setPassword($passwordOriginal);
            }

            $entityManager->flush();

            return $this->redirectToRoute('usuario_index', ['id' => $usuario->getId()]);
        }

        return $this->render('usuario/edit.html.twig', [
            'usuario' => $usuario,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/{id}/state', name: 'usuario_change_state', methods: 'POST')]
    public function state(Request $request, Usuario $usuario, UsuarioManager $manager): Response
    {
        $this->denyAccess([Permission::ENABLE, Permission::DISABLE], $usuario);

        if ($this->isCsrfTokenValid('change_state'.$usuario->getId(), $request->request->get('_token'))) {
            $usuario->changeActive();
            if ($manager->save($usuario)) {
                $this->addFlash('warning', 'Registro actualizado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('usuario_index');
    }

    #[Route(path: '/{id}/delete', name: 'usuario_delete', methods: ['POST'])]
    public function deleteForever(Request $request, Usuario $usuario, UsuarioManager $manager): Response
    {
        $this->denyAccess([Permission::DELETE], $usuario);
        if ($this->isCsrfTokenValid('delete_forever'.$usuario->getId(), $request->request->get('_token'))) {
            if ($manager->remove($usuario)) {
                $this->addFlash('warning', 'Registro eliminado');
            } else {
                $this->addErrors($manager->errors());
            }
        }

        return $this->redirectToRoute('usuario_index');
    }

    #[Route(path: '/{id}/profile', name: 'usuario_profile', methods: 'GET')]
    public function profile(Usuario $usuario): Response
    {
        $this->denyAccess([Permission::SHOW], $usuario);

        return $this->render('usuario/profile.html.twig', [
            'usuario' => $usuario,
        ]);
    }
}
