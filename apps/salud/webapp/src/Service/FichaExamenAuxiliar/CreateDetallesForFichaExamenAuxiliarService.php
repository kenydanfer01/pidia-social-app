<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Salud\Webapp\Service\FichaExamenAuxiliar;

use SocialApp\Apps\Salud\Webapp\Entity\FichaExamenAuxiliar;
use SocialApp\Apps\Salud\Webapp\Entity\FichaExamenAuxiliarDetalle;
use SocialApp\Apps\Salud\Webapp\Manager\FichaExamenAuxiliarDetalleManager;
use SocialApp\Apps\Salud\Webapp\Manager\FichaExamenAuxiliarManager;

class CreateDetallesForFichaExamenAuxiliarService
{
    public function __construct(
        private readonly FichaExamenAuxiliarDetalleManager $fichaExamenAuxiliarDetalleManager,
        private readonly FichaExamenAuxiliarManager $fichaExamenAuxiliarManager,
    ) {
    }

    public function execute(FichaExamenAuxiliar $fichaExamenAuxiliar): void
    {
        $formato = $fichaExamenAuxiliar->getExamenAuxiliar()?->getFormato();

        if (null === $formato) {
            return;
        }

        $detalleNombres = explode(', ', $formato);

        foreach ($detalleNombres as $nombre) {
            $fichaExamenAuxiliarDetalle = new FichaExamenAuxiliarDetalle();
            $fichaExamenAuxiliarDetalle->setFichaExamenAuxiliar($fichaExamenAuxiliar);
            $fichaExamenAuxiliarDetalle->setNombre($nombre);
            $fichaExamenAuxiliar->addDetalle($fichaExamenAuxiliarDetalle);
            $this->fichaExamenAuxiliarDetalleManager->save($fichaExamenAuxiliarDetalle);
            $this->fichaExamenAuxiliarManager->save($fichaExamenAuxiliar);
        }
    }
}
