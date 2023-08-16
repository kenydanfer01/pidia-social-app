<?php

namespace SocialApp\Apps\Financiero\Webapp\Service\reporte;

use SocialApp\Apps\Financiero\Webapp\Entity\Socio;
use SocialApp\Apps\Financiero\Webapp\Repository\SoporteRepository;

class soportesBySocioService
{
    public function __construct(
        private readonly SoporteRepository $soporteRepository,
    )
    {
    }

    public function execute(int  $socioId):array
    {
        $items=[];
        $montoTotal = 0.00;
        $amortizacionTotal = 0.00;

        $soportesBySocio=$this->soporteRepository->getAllSoportesBySocio($socioId);
        foreach ($soportesBySocio as $soporte){
            $montoTotal += $soporte->getMonto();
            $amortizacionTotal += $soporte->getAmortizacion();
            $items[] = [
                'id' => $soporte->getId(),
                'socio'=>$soporte->getSocio()->getApellidoPaterno().' '.$soporte->getSocio()->getApellidoMaterno().', '.$soporte->getSocio()->getNombres(),
                'tipoSoporte'=>$soporte->getTipoSoporte()->getNombre(),
                'monto'=>$soporte->getMonto(),
                'amortizacion'=>$soporte->getAmortizacion(),
                'saldo'=>sprintf("%.2f", $soporte->getMonto() - $soporte->getAmortizacion()),
            ];
        }
        $saldoTotal = $montoTotal - $amortizacionTotal;
        return [
            'items'=>$items,
            'montoTotal'=> sprintf("%.2f", $montoTotal),
            'amortizacionTotal'=>sprintf("%.2f", $amortizacionTotal),
            'saldoTotal'=>sprintf("%.2f", $saldoTotal),
        ];
    }
}
