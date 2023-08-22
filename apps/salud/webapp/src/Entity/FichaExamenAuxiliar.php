<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Salud\Webapp\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use SocialApp\Apps\Salud\Webapp\Entity\Traits\EntityTrait;
use SocialApp\Apps\Salud\Webapp\Repository\FichaExamenAuxiliarRepository;

#[ORM\Entity(repositoryClass: FichaExamenAuxiliarRepository::class)]
#[HasLifecycleCallbacks]
class FichaExamenAuxiliar
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'fichaExamenesAuxiliares')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FichaEvaluacion $fichaEvaluacion = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ExamenAuxiliar $examenAuxiliar = null;

    #[ORM\OneToMany(mappedBy: 'fichaExamenAuxiliar', targetEntity: FichaExamenAuxiliarDetalle::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $detalles;

    public function __construct()
    {
        $this->detalles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFichaEvaluacion(): ?FichaEvaluacion
    {
        return $this->fichaEvaluacion;
    }

    public function setFichaEvaluacion(?FichaEvaluacion $fichaEvaluacion): static
    {
        $this->fichaEvaluacion = $fichaEvaluacion;

        return $this;
    }

    public function getExamenAuxiliar(): ?ExamenAuxiliar
    {
        return $this->examenAuxiliar;
    }

    public function setExamenAuxiliar(?ExamenAuxiliar $examenAuxiliar): static
    {
        $this->examenAuxiliar = $examenAuxiliar;

        return $this;
    }

    /**
     * @return Collection<int, FichaExamenAuxiliarDetalle>
     */
    public function getDetalles(): Collection
    {
        return $this->detalles;
    }

    public function addDetalle(FichaExamenAuxiliarDetalle $detalle): static
    {
        if (!$this->detalles->contains($detalle)) {
            $this->detalles->add($detalle);
            $detalle->setFichaExamenAuxiliar($this);
        }

        return $this;
    }

    public function removeDetalle(FichaExamenAuxiliarDetalle $detalle): static
    {
        if ($this->detalles->removeElement($detalle)) {
            // set the owning side to null (unless already changed)
            if ($detalle->getFichaExamenAuxiliar() === $this) {
                $detalle->setFichaExamenAuxiliar(null);
            }
        }

        return $this;
    }
}
