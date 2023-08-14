<?php

namespace SocialApp\Apps\Financiero\Webapp\Filter\Dto;

use SocialApp\Apps\Financiero\Webapp\Entity\Socio;
use SocialApp\Apps\Financiero\Webapp\Entity\TipoSoporte;

class SoporteFilterDto
{
    public ?Socio $socio = null;
    public ?TipoSoporte $tipoSoporte = null;
    public ?int $page = null;
    public ?int $limit = null;


    /**
     * @return Socio|null
     */
    public function getSocio(): ?Socio
    {
        return $this->socio;
    }

    /**
     * @return TipoSoporte|null
     */
    public function getTipoSoporte(): ?TipoSoporte
    {
        return $this->tipoSoporte;
    }



}
