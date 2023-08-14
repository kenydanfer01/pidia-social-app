<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Financiero\Webapp\Service\soporte;

use SocialApp\Apps\Financiero\Webapp\Entity\Pago;
use SocialApp\Apps\Financiero\Webapp\Filter\Dto\EditPagoDto;
use SocialApp\Apps\Financiero\Webapp\Repository\PagoRepository;

class IsValidPaymentService
{
    public function __construct(
        private readonly PagoRepository $pagoRepository,
    ) {
    }

    public function executeForPago(?Pago $pago): bool
    {
        $soporte = $pago?->getSoporte();
        $montoSoporte = (float) ($soporte?->getMonto() ?? 0.0);
        $amortizacionSoporte = (float) ($soporte?->getAmortizacion() ?? 0.0);

        $debe = $montoSoporte - $amortizacionSoporte;
        $montoPago = (float) ($pago?->getPago() ?? 0.0);

        if ($montoPago <= $debe) {
            return true;
        }

        return false;
    }

    public function executeForEditPagoDto(EditPagoDto $editPagoDto): bool
    {
        $pago = $this->pagoRepository->find($editPagoDto->idPago);
        $credito = $pago?->getSoporte();
        $montoCredito = (float) ($credito?->getMonto() ?? 0.0);
        $amortizacionCredito = (float) ($credito?->getAmortizacion() ?? 0.0) - (float) ($pago?->getPago() ?? 0.0);

        $debe = $montoCredito - $amortizacionCredito;
        $montoPago = $editPagoDto->ePago ?? 0.0;

        if ($montoPago <= $debe) {
            return true;
        }

        return false;
    }
}
