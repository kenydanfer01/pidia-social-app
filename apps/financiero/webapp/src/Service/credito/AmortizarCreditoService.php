<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Financiero\Webapp\Service\credito;

use SocialApp\Apps\Financiero\Webapp\Entity\Pago;
use SocialApp\Apps\Financiero\Webapp\Repository\CreditoRepository;

class AmortizarCreditoService
{
    public function __construct(
        private readonly CreditoRepository $creditoRepository,
    ) {
    }

    public function execute(Pago $pago): void
    {
        $credito = $pago->getCredito();
        $amortizacionCredito = (float) ($credito?->getAmortizacion() ?? 0.0);
        $montoPago = (float) ($pago?->getPago() ?? 0.0);
        $amortizacionCredito += $montoPago;
        $credito?->setAmortizacion($amortizacionCredito);
        $this->creditoRepository->save($credito);
    }

    public function actualizarAmortizacionDespuesDeEliminarPago($credito, $montoEliminado)
    {
        $amortizacionActual = $credito->getAmortizacion();
        $nuevaAmortizacion = $amortizacionActual - $montoEliminado;

        $credito->setAmortizacion($nuevaAmortizacion);
        $this->creditoRepository->save($credito);
    }
}
