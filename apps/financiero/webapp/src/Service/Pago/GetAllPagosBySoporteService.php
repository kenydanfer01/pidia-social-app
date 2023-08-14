<?php

namespace SocialApp\Apps\Financiero\Webapp\Service\Pago;


use SocialApp\Apps\Financiero\Webapp\Repository\PagoRepository;

class GetAllPagosBySoporteService
{
    public function __construct(
        private readonly pagoRepository $pagoRepository,
    )
    {
    }

    public function execute(int $soporteId):array
    {
        $items=[];
        $pagosBySoporte=$this->pagoRepository->getAllPagosBySoporte($soporteId);
        foreach ($pagosBySoporte as $pago){
            $items[] = [
                'id' => $pago->getId(),
                'montopagado' => $pago->getPago(),
                'fecha' => $pago->getFecha(),
            ];
        }
        return $items;
    }
}
