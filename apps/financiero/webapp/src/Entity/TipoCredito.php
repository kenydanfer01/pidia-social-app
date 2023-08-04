<?php

namespace SocialApp\Apps\Financiero\Webapp\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use SocialApp\Apps\Financiero\Webapp\Entity\Traits\EntityTrait;
use SocialApp\Apps\Financiero\Webapp\Repository\TipoCreditoRepository;

#[ORM\Entity(repositoryClass: TipoCreditoRepository::class)]
#[HasLifecycleCallbacks]
class TipoCredito
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $nombre = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $codigoCuenta = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCodigoCuenta(): ?string
    {
        return $this->codigoCuenta;
    }

    public function setCodigoCuenta(?string $codigoCuenta): static
    {
        $this->codigoCuenta = $codigoCuenta;

        return $this;
    }
    public function __toString(): string
    {
        return $this->nombre;
    }
}
