<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Salud\Webapp\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use SocialApp\Apps\Salud\Webapp\Entity\Traits\EntityTrait;
use SocialApp\Apps\Salud\Webapp\Repository\FichaEvaluacionRepository;

#[ORM\Entity(repositoryClass: FichaEvaluacionRepository::class)]
#[HasLifecycleCallbacks]
class FichaEvaluacion
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $diagnostico = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $intervenciones = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $tratamiento = null;

    #[ORM\ManyToOne(inversedBy: 'fichasEvaluaciones')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Paciente $paciente = null;

    #[ORM\ManyToMany(targetEntity: EnfermedadAsociada::class)]
    private Collection $enfermedadesAsociadas;

    #[ORM\OneToOne(inversedBy: 'fichaEvaluacion', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\JoinColumn(nullable: true)]
    private ?ExamenFisico $examenFisico = null;

    #[ORM\OneToOne(inversedBy: 'fichaEvaluacion', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\JoinColumn(nullable: true)]
    private ?EvaluacionClinica $evaluacionClinica = null;

    public function __construct()
    {
        $this->enfermedadesAsociadas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiagnostico(): ?string
    {
        return $this->diagnostico;
    }

    public function setDiagnostico(?string $diagnostico): static
    {
        $this->diagnostico = $diagnostico;

        return $this;
    }

    public function getIntervenciones(): ?string
    {
        return $this->intervenciones;
    }

    public function setIntervenciones(?string $intervenciones): static
    {
        $this->intervenciones = $intervenciones;

        return $this;
    }

    public function getTratamiento(): ?string
    {
        return $this->tratamiento;
    }

    public function setTratamiento(?string $tratamiento): static
    {
        $this->tratamiento = $tratamiento;

        return $this;
    }

    public function getPaciente(): ?Paciente
    {
        return $this->paciente;
    }

    public function setPaciente(?Paciente $paciente): static
    {
        $this->paciente = $paciente;

        return $this;
    }

    /**
     * @return Collection<int, EnfermedadAsociada>
     */
    public function getEnfermedadesAsociadas(): Collection
    {
        return $this->enfermedadesAsociadas;
    }

    public function addEnfermedadesAsociada(EnfermedadAsociada $enfermedadesAsociada): static
    {
        if (!$this->enfermedadesAsociadas->contains($enfermedadesAsociada)) {
            $this->enfermedadesAsociadas->add($enfermedadesAsociada);
        }

        return $this;
    }

    public function removeEnfermedadesAsociada(EnfermedadAsociada $enfermedadesAsociada): static
    {
        $this->enfermedadesAsociadas->removeElement($enfermedadesAsociada);

        return $this;
    }

    public function getExamenFisico(): ?ExamenFisico
    {
        return $this->examenFisico;
    }

    public function setExamenFisico(?ExamenFisico $examenFisico): static
    {
        $this->examenFisico = $examenFisico;

        return $this;
    }

    public function getEvaluacionClinica(): ?EvaluacionClinica
    {
        return $this->evaluacionClinica;
    }

    public function setEvaluacionClinica(?EvaluacionClinica $evaluacionClinica): static
    {
        $this->evaluacionClinica = $evaluacionClinica;

        return $this;
    }
}
