<?php

namespace SocialApp\Apps\Financiero\Webapp\Controller;

use CarlosChininin\App\Infrastructure\Controller\WebAuthController;
use SocialApp\Apps\Financiero\Webapp\Repository\SocioRepository;
use SocialApp\Apps\Financiero\Webapp\Service\reporte\soportesBySocioService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

#[Route('/admin/reporte')]
class ReporteController extends WebAuthController
{
    public const BASE_ROUTE = 'reporte_index';
    #[Route(path: '/soportes', name: 'reporte_soportes', methods: ['GET','POST'])]
    public function reporteSoportesBySocio(
        SocioRepository $socioRepository,
        soportesBySocioService $soportesBySocioService,
        Request $request,
    ): Response {

        $socioId= $request->get('socio');
        if (null === $socioId) {
            $socioId = 3;
        }

        $data =$soportesBySocioService->execute($socioId);

        return $this->render(
            'reporte/soportes.html.twig',
            [
                'socios'=>$socioRepository->findBy(['isActive'=>true]),
                'idSocio'=>$socioId ?? 3,
                'data'=>$data['items'],
                'montoTotal' => $data['montoTotal'],
                'amortizacionTotal' => $data['amortizacionTotal'],
                'saldoTotal' => $data['saldoTotal'],
            ]
        );
    }
}
