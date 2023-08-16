<?php

namespace SocialApp\Apps\Financiero\Webapp\Service\reporte;

use SocialApp\Apps\Financiero\Webapp\Repository\ProyeccionRepository;

class proyeccionesBySocioService
{
    public function __construct(
        private readonly proyeccionRepository $proyeccionRepository,
    )
    {
    }


    public function execute(int $socioId) : array
    {
        $items=[];
        $proyeccionesBySocio=$this->proyeccionRepository->getAllProyeccionBySocio($socioId);
        foreach ($proyeccionesBySocio as $proyeccion){
            $items[] = [
                'id' => $proyeccion->getId(),
                'socio'=>$proyeccion->getSocio()->getApellidoPaterno().' '.$proyeccion->getSocio()->getApellidoMaterno().', '.$proyeccion->getSocio()->getNombres(),
                'anio'=>$proyeccion->getAnio(),
                'proyeccion'=>$proyeccion->getQuintales(),
                'acopio'=>$proyeccion->getAcopiadoQuintales(),
                'aporte'=>$proyeccion->getAporte(),
                'pagoAporte'=>$proyeccion->getPagoAporte(),
            ];
        }
        return $items;
    }
}
