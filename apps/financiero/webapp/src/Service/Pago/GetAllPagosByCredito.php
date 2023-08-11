<?php

namespace SocialApp\Apps\Financiero\Webapp\Service\Pago;


use SocialApp\Apps\Financiero\Webapp\Repository\PagoRepository;

class GetAllPagosByCredito
{
    public function __construct(
        private readonly pagoRepository $pagoRepository,
    )
    {
    }

    public function execute(int $creditoId):array
    {
        $items=[];
        $pagosByCredito=$this->pagoRepository->getAllPagosByCredito($creditoId);
        foreach ($pagosByCredito as $pago){
            $items[] = [
                'id' => $pago->getId(),
                'montopagado' => $pago->getPago(),
                'fecha' => $pago->getFecha(),
            ];
        }
        return $items;
    }
}
