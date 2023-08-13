<?php

namespace SocialApp\Apps\Financiero\Webapp\Service\reporte;

use SocialApp\Apps\Financiero\Webapp\Entity\Socio;
use SocialApp\Apps\Financiero\Webapp\Repository\CreditoRepository;

class soportesBySocioService
{
    public function __construct(
        private readonly creditoRepository $creditoRepository,
    )
    {
    }

    public function execute(int  $socioId):array
    {
        $items=[];
        $montoTotal = 0.00;
        $amortizacionTotal = 0.00;

        $creditosBySocio=$this->creditoRepository->getAllCreditosBySocioV2($socioId);
        foreach ($creditosBySocio as $credito){
            $montoTotal += $credito->getMonto();
            $amortizacionTotal += $credito->getAmortizacion();
            $items[] = [
                'id' => $credito->getId(),
                'socio'=>$credito->getSocio()->getApellidoPaterno().' '.$credito->getSocio()->getApellidoMaterno().', '.$credito->getSocio()->getNombres(),
                'tipoCredito'=>$credito->getTipoCredito()->getNombre(),
                'monto'=>$credito->getMonto(),
                'amortizacion'=>$credito->getAmortizacion(),
                'saldo'=>sprintf("%.2f", $credito->getMonto() - $credito->getAmortizacion()),
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
