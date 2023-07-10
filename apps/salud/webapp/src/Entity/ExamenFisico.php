<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Salud\Webapp\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use SocialApp\Apps\Salud\Webapp\Entity\Traits\EntityTrait;
use SocialApp\Apps\Salud\Webapp\Repository\ExamenFisicoRepository;

#[ORM\Entity(repositoryClass: ExamenFisicoRepository::class)]
#[HasLifecycleCallbacks]
class ExamenFisico
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 7, nullable: true)]
    private ?string $presionArterial = null;

    #[ORM\Column(nullable: true)]
    private ?int $frecuenciaCardiaca = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2, nullable: true)]
    private ?string $temperatura = null;

    #[ORM\Column(nullable: true)]
    private ?int $frecuenciaRespiratoria = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2, nullable: true)]
    private ?string $peso = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: 2, nullable: true)]
    private ?string $talla = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2, nullable: true)]
    private ?string $imc = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observaciones = null;

    #[ORM\OneToOne(mappedBy: 'examenFisico', cascade: ['persist', 'remove'])]
    private ?FichaEvaluacion $fichaEvaluacion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPresionArterial(): ?string
    {
        return $this->presionArterial;
    }

    public function setPresionArterial(?string $presionArterial): static
    {
        $this->presionArterial = $presionArterial;

        return $this;
    }

    public function getFrecuenciaCardiaca(): ?int
    {
        return $this->frecuenciaCardiaca;
    }

    public function setFrecuenciaCardiaca(?int $frecuenciaCardiaca): static
    {
        $this->frecuenciaCardiaca = $frecuenciaCardiaca;

        return $this;
    }

    public function getTemperatura(): ?string
    {
        return $this->temperatura;
    }

    public function setTemperatura(?string $temperatura): static
    {
        $this->temperatura = $temperatura;

        return $this;
    }

    public function getFrecuenciaRespiratoria(): ?int
    {
        return $this->frecuenciaRespiratoria;
    }

    public function setFrecuenciaRespiratoria(?int $frecuenciaRespiratoria): static
    {
        $this->frecuenciaRespiratoria = $frecuenciaRespiratoria;

        return $this;
    }

    public function getPeso(): ?string
    {
        return $this->peso;
    }

    public function setPeso(?string $peso): static
    {
        $this->peso = $peso;

        return $this;
    }

    public function getTalla(): ?string
    {
        return $this->talla;
    }

    public function setTalla(?string $talla): static
    {
        $this->talla = $talla;

        return $this;
    }

    public function getImc(): ?string
    {
        return $this->imc;
    }

    public function setImc(?string $imc): static
    {
        $this->imc = $imc;

        return $this;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(?string $observaciones): static
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    public function getFichaEvaluacion(): ?FichaEvaluacion
    {
        return $this->fichaEvaluacion;
    }

    public function setFichaEvaluacion(?FichaEvaluacion $fichaEvaluacion): static
    {
        // unset the owning side of the relation if necessary
        if (null === $fichaEvaluacion && null !== $this->fichaEvaluacion) {
            $this->fichaEvaluacion->setExamenFisico(null);
        }

        // set the owning side of the relation if necessary
        if (null !== $fichaEvaluacion && $fichaEvaluacion->getExamenFisico() !== $this) {
            $fichaEvaluacion->setExamenFisico($this);
        }

        $this->fichaEvaluacion = $fichaEvaluacion;

        return $this;
    }
    public function __toString(): string
    {
        return $this->getObservaciones();
    }
}
