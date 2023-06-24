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
use SocialApp\Apps\Salud\Webapp\Repository\PacienteRepository;

#[ORM\Entity(repositoryClass: PacienteRepository::class)]
#[HasLifecycleCallbacks]
class Paciente
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 8)]
    private ?string $dni = null;

    #[ORM\Column(length: 30)]
    private ?string $apellidoPaterno = null;

    #[ORM\Column(length: 30)]
    private ?string $apellidoMaterno = null;

    #[ORM\Column(length: 50)]
    private ?string $nombres = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $direccion = null;

    #[ORM\Column(length: 15)]
    private ?string $telefono = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fechaNacimiento = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Parametro $estadoCivil = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Parametro $sexo = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Parametro $posicion = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    private ?self $titular = null;

    #[ORM\ManyToOne(inversedBy: 'asociados')]
    private ?BaseSocial $baseSocial = null;

    public function __toString(): string
    {
        return $this->apellidoPaterno.' '.$this->apellidoMaterno.' '.$this->nombres;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getApellidoPaterno(): ?string
    {
        return $this->apellidoPaterno;
    }

    public function setApellidoPaterno(string $apellidoPaterno): static
    {
        $this->apellidoPaterno = $apellidoPaterno;

        return $this;
    }

    public function getApellidoMaterno(): ?string
    {
        return $this->apellidoMaterno;
    }

    public function setApellidoMaterno(string $apellidoMaterno): static
    {
        $this->apellidoMaterno = $apellidoMaterno;

        return $this;
    }

    public function getNombres(): ?string
    {
        return $this->nombres;
    }

    public function setNombres(string $nombres): static
    {
        $this->nombres = $nombres;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): static
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(\DateTimeInterface $fechaNacimiento): static
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    public function getEstadoCivil(): ?Parametro
    {
        return $this->estadoCivil;
    }

    public function setEstadoCivil(?Parametro $estadoCivil): static
    {
        $this->estadoCivil = $estadoCivil;

        return $this;
    }

    public function getSexo(): ?Parametro
    {
        return $this->sexo;
    }

    public function setSexo(?Parametro $sexo): static
    {
        $this->sexo = $sexo;

        return $this;
    }

    public function getPosicion(): ?Parametro
    {
        return $this->posicion;
    }

    public function setPosicion(?Parametro $posicion): static
    {
        $this->posicion = $posicion;

        return $this;
    }

    public function getTitular(): ?self
    {
        return $this->titular;
    }

    public function setTitular(?self $titular): static
    {
        $this->titular = $titular;

        return $this;
    }

    public function getBaseSocial(): ?BaseSocial
    {
        return $this->baseSocial;
    }

    public function setBaseSocial(?BaseSocial $baseSocial): static
    {
        $this->baseSocial = $baseSocial;

        return $this;
    }
}
