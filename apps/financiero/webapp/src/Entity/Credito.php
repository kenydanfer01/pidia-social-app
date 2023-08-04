<?php

namespace SocialApp\Apps\Financiero\Webapp\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use SocialApp\Apps\Financiero\Webapp\Entity\Traits\EntityTrait;
use SocialApp\Apps\Financiero\Webapp\Repository\CreditoRepository;

#[ORM\Entity(repositoryClass: CreditoRepository::class)]
#[HasLifecycleCallbacks]
class Credito
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?Socio $socio = null;

    #[ORM\ManyToOne]
    private ?TipoCredito $tipoCredito = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 11, scale: 2, nullable: true)]
    private ?string $monto = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 11, scale: 2, nullable: true)]
    private ?string $amortizacion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSocio(): ?Socio
    {
        return $this->socio;
    }

    public function setSocio(?Socio $socio): static
    {
        $this->socio = $socio;

        return $this;
    }

    public function getTipoCredito(): ?TipoCredito
    {
        return $this->tipoCredito;
    }

    public function setTipoCredito(?TipoCredito $tipoCredito): static
    {
        $this->tipoCredito = $tipoCredito;

        return $this;
    }

    public function getMonto(): ?string
    {
        return $this->monto;
    }

    public function setMonto(?string $monto): static
    {
        $this->monto = $monto;

        return $this;
    }

    public function getAmortizacion(): ?string
    {
        return $this->amortizacion;
    }

    public function setAmortizacion(?string $amortizacion): static
    {
        $this->amortizacion = $amortizacion;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getSocio().' -  S/'.$this->getMonto();
    }
}
