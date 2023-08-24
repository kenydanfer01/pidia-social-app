<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Salud\Webapp\Service\FichaEvaluacion;

use SocialApp\Apps\Salud\Webapp\Entity\FichaEvaluacion;
use SocialApp\Apps\Salud\Webapp\Manager\FichaExamenAuxiliarManager;
use SocialApp\Apps\Salud\Webapp\Repository\ExamenAuxiliarRepository;
use SocialApp\Apps\Salud\Webapp\Repository\FichaExamenAuxiliarRepository;
use SocialApp\Apps\Salud\Webapp\Service\FichaExamenAuxiliar\CreateDetallesForFichaExamenAuxiliarService;
use SocialApp\Apps\Salud\Webapp\Service\FichaExamenAuxiliar\CreateFichasExamenesBySelectedExamenesService;

class UpdateFichaExamenesAuxiliaresInFichaEvaluacionService
{
    public function __construct(
        private readonly FichaExamenAuxiliarRepository $fichaExamenAuxiliarRepository,
        private readonly FichaExamenAuxiliarManager $fichaExamenAuxiliarManager,
        private readonly ExamenAuxiliarRepository $examenAuxiliarRepository,
        private readonly CreateFichasExamenesBySelectedExamenesService $createFichasExamenesBySelectedExamenesService,
        private readonly CreateDetallesForFichaExamenAuxiliarService $createDetallesForFichaExamenAuxiliarService,
    ) {
    }

    public function execute(FichaEvaluacion $fichaEvaluacion, array $idsExamenesAuxiliaresBefore): void
    {
        $idsExamenesAuxiliaresAfter = $this->idsExamenesAuxiliares($fichaEvaluacion);
        $this->removeFichaExamenesAuxiliares($idsExamenesAuxiliaresBefore, $idsExamenesAuxiliaresAfter);
        $this->createFichaExamenesAuxiliares($idsExamenesAuxiliaresBefore, $idsExamenesAuxiliaresAfter, $fichaEvaluacion);
    }

    public function idsExamenesAuxiliares(FichaEvaluacion $fichaEvaluacion): array
    {
        $examenesAuxiliares = $fichaEvaluacion->getExamenesAuxiliares()->getValues();
        $output = [];
        foreach ($examenesAuxiliares as $examenAuxiliar) {
            $output[] = $examenAuxiliar->getId();
        }

        return $output;
    }

    private function removeFichaExamenesAuxiliares(array $idsExamenesAuxiliaresBefore, array $idsExamenesAuxiliaresAfter): void
    {
        $idsExamenesAuxiliaresRemoved = array_diff($idsExamenesAuxiliaresBefore, $idsExamenesAuxiliaresAfter);

        if ([] === $idsExamenesAuxiliaresRemoved) {
            return;
        }

        foreach ($idsExamenesAuxiliaresRemoved as $idExamenAuxiliar) {
            $fichaExamenAuxiliar = $this->fichaExamenAuxiliarRepository->findOneBy(['examenAuxiliar' => $idExamenAuxiliar]);

            if (null === $fichaExamenAuxiliar) {
                continue;
            }

            $this->fichaExamenAuxiliarManager->remove($fichaExamenAuxiliar);
        }
    }

    private function createFichaExamenesAuxiliares(array $idsExamenesAuxiliaresBefore, array $idsExamenesAuxiliaresAfter, FichaEvaluacion $fichaEvaluacion): void
    {
        $idsExamenesAuxiliaresCreated = array_diff($idsExamenesAuxiliaresAfter, $idsExamenesAuxiliaresBefore);

        if ([] === $idsExamenesAuxiliaresCreated) {
            return;
        }

        foreach ($idsExamenesAuxiliaresCreated as $idExamenAuxiliar) {
            $examenAuxiliar = $this->examenAuxiliarRepository->find($idExamenAuxiliar);
            $fichaExamenAuxiliar = $this->createFichasExamenesBySelectedExamenesService->createFichaExamenAuxiliar($fichaEvaluacion, $examenAuxiliar);
            $this->fichaExamenAuxiliarManager->save($fichaExamenAuxiliar);
            $this->createDetallesForFichaExamenAuxiliarService->execute($fichaExamenAuxiliar);
        }
    }
}
