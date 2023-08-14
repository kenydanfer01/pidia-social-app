<?php

namespace SocialApp\Apps\Financiero\Webapp\Controller;

use CarlosChininin\App\Infrastructure\Controller\WebAuthController;
use SocialApp\Apps\Financiero\Webapp\Repository\SocioRepository;
use SocialApp\Apps\Financiero\Webapp\Service\reporte\proyeccionesBySocioService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin/reporte_proyecciones')]
class ReporteProyeccionesController extends WebAuthController
{
    public const BASE_ROUTE = 'reporte_proyecciones_index';

    #[Route(path: '/', name: 'reporte_proyecciones_index', methods: ['GET','POST'])]
    public function reportePoryeccionesBySocio(
        SocioRepository $socioRepository,
        proyeccionesBySocioService $proyeccionesBySocioService,
        Request $request,
    ): Response {

        $socioId= $request->get('socio');
        if (null === $socioId) {
            $socioId = 3;
        }

        $data =$proyeccionesBySocioService->execute($socioId);

        return $this->render(
            'reporte/proyecciones.html.twig',
            [
                'socios'=>$socioRepository->findBy(['isActive'=>true]),
                'idSocio'=>$socioId,
                'data'=>$data,
            ]
        );
    }
}
