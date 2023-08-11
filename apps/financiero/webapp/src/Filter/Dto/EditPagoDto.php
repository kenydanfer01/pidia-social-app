<?php

namespace SocialApp\Apps\Financiero\Webapp\Filter\Dto;

final class EditPagoDto
{
    public ?int $idPago = null;

    public ?int $ePago = null;
    public ?\DateTime $fechaPagoEdit = null;

    /**
     * @return int|null
     */
    public function getIdPago(): ?int
    {
        return $this->idPago;
    }

    /**
     * @return int|null
     */
    public function getEPago(): ?int
    {
        return $this->ePago;
    }

    /**
     * @return \DateTime|null
     */
    public function getFechaPagoEdit(): ?\DateTime
    {
        return $this->fechaPagoEdit;
    }

}
