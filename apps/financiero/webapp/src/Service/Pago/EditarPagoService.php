<?php

namespace SocialApp\Apps\Financiero\Webapp\Service\Pago;

use Doctrine\ORM\EntityManagerInterface;
use SocialApp\Apps\Financiero\Webapp\Repository\PagoRepository;
use SocialApp\Apps\Financiero\Webapp\Service\credito\AmortizarCreditoService;

class EditarPagoService
{
    private $entityManager;
    private $pagoRepository;
    private $amortizarCreditoService;
    public function __construct(
        EntityManagerInterface $entityManager,
        PagoRepository $pagoRepository,
        AmortizarCreditoService $amortizarCreditoService
    ) {
        $this->entityManager = $entityManager;
        $this->pagoRepository = $pagoRepository;
        $this->amortizarCreditoService = $amortizarCreditoService;
    }

    public function execute($idPago, $ePago, $eFechaPago)
    {
        $pagoRepo = $this->pagoRepository->findOneBy(['id' => $idPago]);
        $credito = $pagoRepo?->getCredito();
        if ($pagoRepo) {
            $montoOriginal = $pagoRepo->getPago();
            $pagoRepo->setPago($ePago);
            $pagoRepo->setFecha($eFechaPago);
            $this->entityManager->flush();
            $this->amortizarCreditoService->actualizarAmortizacionDespuesDeEditarPago($credito, $montoOriginal, $ePago);
        }
    }

}
