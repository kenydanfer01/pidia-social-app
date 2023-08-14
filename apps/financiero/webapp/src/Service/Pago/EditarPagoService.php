<?php

namespace SocialApp\Apps\Financiero\Webapp\Service\Pago;

use Doctrine\ORM\EntityManagerInterface;
use SocialApp\Apps\Financiero\Webapp\Repository\PagoRepository;
use SocialApp\Apps\Financiero\Webapp\Service\soporte\AmortizarSoporteService;

class EditarPagoService
{
    private $entityManager;
    private $pagoRepository;
    private $amortizarSoporteService;
    public function __construct(
        EntityManagerInterface $entityManager,
        PagoRepository $pagoRepository,
        AmortizarSoporteService $amortizarSoporteService
    ) {
        $this->entityManager = $entityManager;
        $this->pagoRepository = $pagoRepository;
        $this->amortizarSoporteService = $amortizarSoporteService;
    }


    public function execute($idPago, $ePago, $eFechaPago)
    {
        $pagoRepo = $this->pagoRepository->findOneBy(['id' => $idPago]);
        $soporte = $pagoRepo?->getSoporte();
        if ($pagoRepo) {
            $montoOriginal = $pagoRepo->getPago();
            $pagoRepo->setPago($ePago);
            $pagoRepo->setFecha($eFechaPago);
            $this->entityManager->flush();
            $this->amortizarSoporteService->actualizarAmortizacionDespuesDeEditarPago($soporte, $montoOriginal, $ePago);
        }
    }

}
