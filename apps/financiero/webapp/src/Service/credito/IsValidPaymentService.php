<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Financiero\Webapp\Service\credito;

use SocialApp\Apps\Financiero\Webapp\Entity\Pago;

class IsValidPaymentService
{
    public function execute(Pago $pago): bool
    {
        $credito = $pago->getCredito();
        $montoCredito = (float) ($credito?->getMonto() ?? 0.0);
        $amortizacionCredito = (float) ($credito?->getAmortizacion() ?? 0.0);

        $debe = $montoCredito - $amortizacionCredito;
        $montoPago = (float) ($pago?->getPago() ?? 0.0);

        if ($montoPago <= $debe) {
            return true;
        }

        return false;
    }
}
