<?php

namespace SocialApp\Apps\Financiero\Webapp\Filter\Dto;

use SocialApp\Apps\Financiero\Webapp\Entity\Socio;
use SocialApp\Apps\Financiero\Webapp\Entity\TipoCredito;

class CreditoFilterDto
{
    public ?Socio $socio = null;
    public ?TipoCredito $tipoCredito = null;
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
     * @return TipoCredito|null
     */
    public function getTipoCredito(): ?TipoCredito
    {
        return $this->tipoCredito;
    }



}
