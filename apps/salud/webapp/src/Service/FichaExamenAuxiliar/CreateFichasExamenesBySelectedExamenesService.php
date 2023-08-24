<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Salud\Webapp\Service\FichaExamenAuxiliar;

use SocialApp\Apps\Salud\Webapp\Entity\ExamenAuxiliar;
use SocialApp\Apps\Salud\Webapp\Entity\FichaEvaluacion;
use SocialApp\Apps\Salud\Webapp\Entity\FichaExamenAuxiliar;
use SocialApp\Apps\Salud\Webapp\Manager\FichaExamenAuxiliarManager;

class CreateFichasExamenesBySelectedExamenesService
{
    public function __construct(
        private readonly FichaExamenAuxiliarManager $fichaExamenAuxiliarManager,
        private readonly CreateDetallesForFichaExamenAuxiliarService $createDetallesForFichaExamenAuxiliarService,
    ) {
    }

    public function execute(FichaEvaluacion $fichaEvaluacion): void
    {
        $examenesAuxiliares = $fichaEvaluacion->getExamenesAuxiliares()->getValues();

        if ([] === $examenesAuxiliares) {
            return;
        }

        foreach ($examenesAuxiliares as $examenAuxiliar) {
            $fichaExamenAuxiliar = $this->createFichaExamenAuxiliar($fichaEvaluacion, $examenAuxiliar);
            $this->fichaExamenAuxiliarManager->save($fichaExamenAuxiliar);
            $this->createDetallesForFichaExamenAuxiliarService->execute($fichaExamenAuxiliar);
        }
    }

    public function createFichaExamenAuxiliar(FichaEvaluacion $fichaEvaluacion, ExamenAuxiliar $examenAuxiliar): FichaExamenAuxiliar
    {
        $fichaExamenAuxiliar = new FichaExamenAuxiliar();
        $fichaExamenAuxiliar->setFichaEvaluacion($fichaEvaluacion);
        $fichaExamenAuxiliar->setExamenAuxiliar($examenAuxiliar);

        return $fichaExamenAuxiliar;
    }
}
