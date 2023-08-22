<?php

namespace SocialApp\Apps\Salud\Webapp\Controller;

use CarlosChininin\App\Infrastructure\Controller\WebAuthController;
use CarlosChininin\App\Infrastructure\Security\Permission;
use SocialApp\Apps\Salud\Webapp\Entity\FichaExamenAuxiliar;
use SocialApp\Apps\Salud\Webapp\Form\FichaExamenAuxiliarType;
use SocialApp\Apps\Salud\Webapp\Manager\FichaExamenAuxiliarManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/ficha_examen_auxiliar')]
class FichaExamenAuxiliarController extends WebAuthController
{
    #[Route(path: '/{id}/edit', name: 'ficha_examen_auxiliar_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FichaExamenAuxiliar $fichaExamenAuxiliar, FichaExamenAuxiliarManager $manager): Response
    {
        $this->denyAccess([Permission::EDIT], $fichaExamenAuxiliar);

        $form = $this->createForm(FichaExamenAuxiliarType::class, $fichaExamenAuxiliar);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($manager->save($fichaExamenAuxiliar)) {
                $this->addFlash('success', 'Registro actualizado!!!');
            } else {
                $this->addErrors($manager->errors());
            }

            return $this->redirectToRoute('ficha_evaluacion_index');
        }

        return $this->render(
            'ficha_examen_auxiliar/edit.html.twig',
            [
                'ficha_examen_auxiliar' => $fichaExamenAuxiliar,
                'form' => $form->createView(),
            ]
        );
    }
}
