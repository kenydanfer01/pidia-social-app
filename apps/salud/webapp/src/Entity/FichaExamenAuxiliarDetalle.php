<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Salud\Webapp\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use SocialApp\Apps\Salud\Webapp\Entity\Traits\EntityTrait;
use SocialApp\Apps\Salud\Webapp\Repository\FichaExamenAuxiliarDetalleRepository;

#[ORM\Entity(repositoryClass: FichaExamenAuxiliarDetalleRepository::class)]
#[HasLifecycleCallbacks]
class FichaExamenAuxiliarDetalle
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'detalles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FichaExamenAuxiliar $fichaExamenAuxiliar = null;

    #[ORM\Column(length: 50)]
    private ?string $nombre = null;

    #[ORM\Column(nullable: true)]
    private ?float $valor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFichaExamenAuxiliar(): ?FichaExamenAuxiliar
    {
        return $this->fichaExamenAuxiliar;
    }

    public function setFichaExamenAuxiliar(?FichaExamenAuxiliar $fichaExamenAuxiliar): static
    {
        $this->fichaExamenAuxiliar = $fichaExamenAuxiliar;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getValor(): ?float
    {
        return $this->valor;
    }

    public function setValor(?float $valor): static
    {
        $this->valor = $valor;

        return $this;
    }
}
