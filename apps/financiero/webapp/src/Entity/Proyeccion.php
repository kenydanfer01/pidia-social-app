<?php

namespace SocialApp\Apps\Financiero\Webapp\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use SocialApp\Apps\Financiero\Webapp\Entity\Traits\EntityTrait;
use SocialApp\Apps\Financiero\Webapp\Repository\ProyeccionRepository;

#[ORM\Entity(repositoryClass: ProyeccionRepository::class)]
#[HasLifecycleCallbacks]
class Proyeccion
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'proyecciones')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Socio $socio = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $quintales = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $acopiadoQuintales = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 11, scale: 2, nullable: true)]
    private ?string $aporte = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 11, scale: 2, nullable: true)]
    private ?string $pagoAporte = null;

    #[ORM\Column(length: 4)]
    private ?string $anio = null;

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

    public function getQuintales(): ?int
    {
        return $this->quintales;
    }

    public function setQuintales(?int $quintales): static
    {
        $this->quintales = $quintales;

        return $this;
    }

    public function getAcopiadoQuintales(): ?int
    {
        return $this->acopiadoQuintales;
    }

    public function setAcopiadoQuintales(?int $acopiadoQuintales): static
    {
        $this->acopiadoQuintales = $acopiadoQuintales;

        return $this;
    }

    public function getAporte(): ?string
    {
        return $this->aporte;
    }

    public function setAporte(?string $aporte): static
    {
        $this->aporte = $aporte;

        return $this;
    }

    public function getPagoAporte(): ?string
    {
        return $this->pagoAporte;
    }

    public function setPagoAporte(?string $pagoAporte): static
    {
        $this->pagoAporte = $pagoAporte;

        return $this;
    }

    public function getAnio(): ?string
    {
        return $this->anio;
    }

    public function setAnio(string $anio): static
    {
        $this->anio = $anio;

        return $this;
    }
}
