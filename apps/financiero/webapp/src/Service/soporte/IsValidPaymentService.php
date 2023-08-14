<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Financiero\Webapp\Service\soporte;

use SocialApp\Apps\Financiero\Webapp\Entity\Pago;

class IsValidPaymentService
{
    public function execute(Pago $pago): bool
    {
        $soporte = $pago->getSoporte();
        $montoSoporte = (float) ($soporte?->getMonto() ?? 0.0);
        $amortizacionSoporte = (float) ($soporte?->getAmortizacion() ?? 0.0);

        $debe = $montoSoporte - $amortizacionSoporte;
        $montoPago = (float) ($pago?->getPago() ?? 0.0);

        if ($montoPago <= $debe) {
            return true;
        }

        return false;
    }
}
