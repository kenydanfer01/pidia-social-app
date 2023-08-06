<?php

namespace SocialApp\Apps\Financiero\Webapp\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use SocialApp\Apps\Financiero\Webapp\Entity\Traits\EntityTrait;
use SocialApp\Apps\Financiero\Webapp\Repository\SocioRepository;

#[ORM\Entity(repositoryClass: SocioRepository::class)]
#[HasLifecycleCallbacks]
class Socio
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 8, nullable: true)]
    private ?string $dni = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $apellidoPaterno = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $apellidoMaterno = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nombres = null;

    #[ORM\Column(length: 12, nullable: true)]
    private ?string $telefono = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fechaNacimiento = null;

    #[ORM\ManyToOne]
    private ?Parametro $estadoCivil = null;

    #[ORM\ManyToOne]
    private ?Parametro $sexo = null;

    #[ORM\ManyToOne]
    private ?BaseSocial $baseSocial = null;

    #[ORM\OneToMany(mappedBy: 'socio', targetEntity: Proyeccion::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $proyecciones;

    public function __construct()
    {
        $this->proyecciones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(?string $dni): static
    {
        $this->dni = $dni;

        return $this;
    }

    public function getApellidoPaterno(): ?string
    {
        return $this->apellidoPaterno;
    }

    public function setApellidoPaterno(?string $apellidoPaterno): static
    {
        $this->apellidoPaterno = $apellidoPaterno;

        return $this;
    }

    public function getApellidoMaterno(): ?string
    {
        return $this->apellidoMaterno;
    }

    public function setApellidoMaterno(?string $apellidoMaterno): static
    {
        $this->apellidoMaterno = $apellidoMaterno;

        return $this;
    }

    public function getNombres(): ?string
    {
        return $this->nombres;
    }

    public function setNombres(?string $nombres): static
    {
        $this->nombres = $nombres;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(?\DateTimeInterface $fechaNacimiento): static
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

    public function __toString(): string
    {
        return $this->apellidoPaterno.' '.$this->apellidoMaterno.', '.$this->nombres;
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

    public function getProyecciones(): Collection
    {
        return $this->proyecciones;
    }

    public function addProyeccion(Proyeccion $proyeccion): static
    {
        if(!$this->proyecciones->contains($proyeccion)) {
            $this->proyecciones->add($proyeccion);
            $proyeccion->setSocio($this);
        }
        return $this;
    }

    public function removeProyecciones(Proyeccion $proyeccion): static
    {
        if ($this->proyecciones->removeElement($proyeccion)) {
            if ($proyeccion->getSocio() === $this) {
                $proyeccion->setSocio(null);
            }
        }
        return $this;
    }
}
