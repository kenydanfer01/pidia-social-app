<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Financiero\Webapp\Service\soporte;

use SocialApp\Apps\Financiero\Webapp\Entity\Pago;
use SocialApp\Apps\Financiero\Webapp\Repository\SoporteRepository;

class AmortizarSoporteService
{
    public function __construct(
        private readonly SoporteRepository $soporteRepository,
    ) {
    }

    public function execute(Pago $pago): void
    {
        $soporte = $pago->getSoporte();
        $amortizacionSoporte = (float) ($soporte?->getAmortizacion() ?? 0.0);
        $montoPago = (float) ($pago?->getPago() ?? 0.0);
        $amortizacionSoporte += $montoPago;
        $soporte?->setAmortizacion($amortizacionSoporte);
        $this->soporteRepository->save($soporte);
    }

    public function actualizarAmortizacionDespuesDeEditarPago($soporte, $montoOriginal, $montoActualizado)
    {
        $amortizacionActual = $soporte->getAmortizacion();
        $diferenciaMontos = $montoActualizado - $montoOriginal;

        $nuevaAmortizacion = $amortizacionActual + $diferenciaMontos;

        $soporte->setAmortizacion($nuevaAmortizacion);
        $this->soporteRepository->save($soporte);
    }

    public function actualizarAmortizacionDespuesDeEliminarPago($soporte, $montoEliminado)
    {
        $amortizacionActual = $soporte->getAmortizacion();
        $nuevaAmortizacion = $amortizacionActual - $montoEliminado;

        $soporte->setAmortizacion($nuevaAmortizacion);
        $this->soporteRepository->save($soporte);
    }
}
