<?php

namespace SocialApp\Apps\Financiero\Webapp\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use SocialApp\Apps\Financiero\Webapp\Entity\Traits\EntityTrait;
use SocialApp\Apps\Financiero\Webapp\Repository\SoporteRepository;

#[ORM\Entity(repositoryClass: SoporteRepository::class)]
#[HasLifecycleCallbacks]
class Soporte
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?Socio $socio = null;

    #[ORM\ManyToOne]
    private ?TipoSoporte $tipoSoporte = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 11, scale: 2, nullable: true)]
    private ?string $monto = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 11, scale: 2, nullable: true)]
    private ?string $amortizacion = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column]
    private ?bool $isPagado = null;

    public function __construct()
    {
        $this->fecha = new \DateTime('now', new \DateTimeZone('America/Lima'));
        $this->isPagado = false;
    }

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

    public function getTipoSoporte(): ?TipoSoporte
    {
        return $this->tipoSoporte;
    }

    public function setTipoSoporte(?TipoSoporte $tipoSoporte): static
    {
        $this->tipoSoporte = $tipoSoporte;

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

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function isIsPagado(): ?bool
    {
        return $this->isPagado;
    }

    public function setIsPagado(bool $isPagado): static
    {
        $this->isPagado = $isPagado;

        return $this;
    }
}
