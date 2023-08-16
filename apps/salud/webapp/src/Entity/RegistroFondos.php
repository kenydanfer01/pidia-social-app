<?php

namespace SocialApp\Apps\Salud\Webapp\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use SocialApp\Apps\Salud\Webapp\Entity\Traits\EntityTrait;
use SocialApp\Apps\Salud\Webapp\Repository\RegistroFondosRepository;

#[ORM\Entity(repositoryClass: RegistroFondosRepository::class)]
#[HasLifecycleCallbacks]
class RegistroFondos
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'registroFondos')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Paciente $paciente = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $condicion = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 7, scale: 2)]
    private ?string $monto = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observacion = null;

    #[ORM\Column(length: 20)]
    private ?string $tipoRegistro = null;

    #[ORM\Column(length: 8, nullable: true)]
    private ?string $dni = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nombreSocio = null;

    #[ORM\Column(length: 70, nullable: true)]
    private ?string $baseSocial = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $tipoSocio = null;

    public function __construct()
    {
        $this->fecha = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCondicion(): ?string
    {
        return $this->condicion;
    }

    public function setCondicion(string $condicion): static
    {
        $this->condicion = $condicion;

        return $this;
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

    public function getMonto(): ?string
    {
        return $this->monto;
    }

    public function setMonto(string $monto): static
    {
        $this->monto = $monto;

        return $this;
    }

    public function getObservacion(): ?string
    {
        return $this->observacion;
    }

    public function setObservacion(?string $observacion): static
    {
        $this->observacion = $observacion;

        return $this;
    }

    public function getTipoRegistro(): ?string
    {
        return $this->tipoRegistro;
    }

    public function setTipoRegistro(string $tipoRegistro): static
    {
        $this->tipoRegistro = $tipoRegistro;

        return $this;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): static
    {
        $this->dni = $dni;

        return $this;
    }

    public function getNombreSocio(): ?string
    {
        return $this->nombreSocio;
    }

    public function setNombreSocio(?string $nombreSocio): static
    {
        $this->nombreSocio = $nombreSocio;

        return $this;
    }

    public function getBaseSocial(): ?string
    {
        return $this->baseSocial;
    }

    public function setBaseSocial(?string $baseSocial): static
    {
        $this->baseSocial = $baseSocial;

        return $this;
    }

    public function getTipoSocio(): ?string
    {
        return $this->tipoSocio;
    }

    public function setTipoSocio(?string $tipoSocio): static
    {
        $this->tipoSocio = $tipoSocio;

        return $this;
    }
}
