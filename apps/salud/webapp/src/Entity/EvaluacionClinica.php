<?php

namespace SocialApp\Apps\Salud\Webapp\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use SocialApp\Apps\Salud\Webapp\Entity\Traits\EntityTrait;
use SocialApp\Apps\Salud\Webapp\Repository\EvaluacionClinicaRepository;

#[ORM\Entity(repositoryClass: EvaluacionClinicaRepository::class)]
#[HasLifecycleCallbacks]
class EvaluacionClinica
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2, nullable: true)]
    private ?string $temperaturaMaxima = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hasFiebre = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hasTos = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hasDolorGarganta = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hasRinorrea = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hasExpectoracion = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hasSibilancias = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hasCongestionFaringea = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hasMedidaTermometro = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hasOtalgia = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hasFotofobia = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hasCongestionConjuntiva = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hasVomitos = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hasDolorAbdominal = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hasDiarrea = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hasAdenopatias = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hasAstenia = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hasCefalea = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hasMialgias = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hasMalestarGeneral = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hasErupcionDermica = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $otros = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemperaturaMaxima(): ?string
    {
        return $this->temperaturaMaxima;
    }

    public function setTemperaturaMaxima(?string $temperaturaMaxima): static
    {
        $this->temperaturaMaxima = $temperaturaMaxima;

        return $this;
    }

    public function isHasFiebre(): ?bool
    {
        return $this->hasFiebre;
    }

    public function setHasFiebre(?bool $hasFiebre): static
    {
        $this->hasFiebre = $hasFiebre;

        return $this;
    }

    public function isHasTos(): ?bool
    {
        return $this->hasTos;
    }

    public function setHasTos(?bool $hasTos): static
    {
        $this->hasTos = $hasTos;

        return $this;
    }

    public function isHasDolorGarganta(): ?bool
    {
        return $this->hasDolorGarganta;
    }

    public function setHasDolorGarganta(?bool $hasDolorGarganta): static
    {
        $this->hasDolorGarganta = $hasDolorGarganta;

        return $this;
    }

    public function isHasRinorrea(): ?bool
    {
        return $this->hasRinorrea;
    }

    public function setHasRinorrea(?bool $hasRinorrea): static
    {
        $this->hasRinorrea = $hasRinorrea;

        return $this;
    }

    public function isHasExpectoracion(): ?bool
    {
        return $this->hasExpectoracion;
    }

    public function setHasExpectoracion(?bool $hasExpectoracion): static
    {
        $this->hasExpectoracion = $hasExpectoracion;

        return $this;
    }

    public function isHasSibilancias(): ?bool
    {
        return $this->hasSibilancias;
    }

    public function setHasSibilancias(?bool $hasSibilancias): static
    {
        $this->hasSibilancias = $hasSibilancias;

        return $this;
    }

    public function isHasCongestionFaringea(): ?bool
    {
        return $this->hasCongestionFaringea;
    }

    public function setHasCongestionFaringea(?bool $hasCongestionFaringea): static
    {
        $this->hasCongestionFaringea = $hasCongestionFaringea;

        return $this;
    }

    public function isHasMedidaTermometro(): ?bool
    {
        return $this->hasMedidaTermometro;
    }

    public function setHasMedidaTermometro(?bool $hasMedidaTermometro): static
    {
        $this->hasMedidaTermometro = $hasMedidaTermometro;

        return $this;
    }

    public function isHasOtalgia(): ?bool
    {
        return $this->hasOtalgia;
    }

    public function setHasOtalgia(?bool $hasOtalgia): static
    {
        $this->hasOtalgia = $hasOtalgia;

        return $this;
    }

    public function isHasFotofobia(): ?bool
    {
        return $this->hasFotofobia;
    }

    public function setHasFotofobia(?bool $hasFotofobia): static
    {
        $this->hasFotofobia = $hasFotofobia;

        return $this;
    }

    public function isHasCongestionConjuntiva(): ?bool
    {
        return $this->hasCongestionConjuntiva;
    }

    public function setHasCongestionConjuntiva(?bool $hasCongestionConjuntiva): static
    {
        $this->hasCongestionConjuntiva = $hasCongestionConjuntiva;

        return $this;
    }

    public function isHasVomitos(): ?bool
    {
        return $this->hasVomitos;
    }

    public function setHasVomitos(?bool $hasVomitos): static
    {
        $this->hasVomitos = $hasVomitos;

        return $this;
    }

    public function isHasDolorAbdominal(): ?bool
    {
        return $this->hasDolorAbdominal;
    }

    public function setHasDolorAbdominal(?bool $hasDolorAbdominal): static
    {
        $this->hasDolorAbdominal = $hasDolorAbdominal;

        return $this;
    }

    public function isHasDiarrea(): ?bool
    {
        return $this->hasDiarrea;
    }

    public function setHasDiarrea(?bool $hasDiarrea): static
    {
        $this->hasDiarrea = $hasDiarrea;

        return $this;
    }

    public function isHasAdenopatias(): ?bool
    {
        return $this->hasAdenopatias;
    }

    public function setHasAdenopatias(?bool $hasAdenopatias): static
    {
        $this->hasAdenopatias = $hasAdenopatias;

        return $this;
    }

    public function isHasAstenia(): ?bool
    {
        return $this->hasAstenia;
    }

    public function setHasAstenia(?bool $hasAstenia): static
    {
        $this->hasAstenia = $hasAstenia;

        return $this;
    }

    public function isHasCefalea(): ?bool
    {
        return $this->hasCefalea;
    }

    public function setHasCefalea(?bool $hasCefalea): static
    {
        $this->hasCefalea = $hasCefalea;

        return $this;
    }

    public function isHasMialgias(): ?bool
    {
        return $this->hasMialgias;
    }

    public function setHasMialgias(?bool $hasMialgias): static
    {
        $this->hasMialgias = $hasMialgias;

        return $this;
    }

    public function isHasMalestarGeneral(): ?bool
    {
        return $this->hasMalestarGeneral;
    }

    public function setHasMalestarGeneral(?bool $hasMalestarGeneral): static
    {
        $this->hasMalestarGeneral = $hasMalestarGeneral;

        return $this;
    }

    public function isHasErupcionDermica(): ?bool
    {
        return $this->hasErupcionDermica;
    }

    public function setHasErupcionDermica(?bool $hasErupcionDermica): static
    {
        $this->hasErupcionDermica = $hasErupcionDermica;

        return $this;
    }

    public function getOtros(): ?string
    {
        return $this->otros;
    }

    public function setOtros(?string $otros): static
    {
        $this->otros = $otros;

        return $this;
    }
}
