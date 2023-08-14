<?php

namespace SocialApp\Apps\Financiero\Webapp\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use SocialApp\Apps\Financiero\Webapp\Entity\Traits\EntityTrait;
use SocialApp\Apps\Financiero\Webapp\Repository\PagoRepository;

#[ORM\Entity(repositoryClass: PagoRepository::class)]
#[HasLifecycleCallbacks]
class Pago
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?Soporte $soporte = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 11, scale: 2, nullable: true)]
    private ?string $pago = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fecha = null;

    public function __construct()
    {
        $this->fecha = new \DateTime('now', new \DateTimeZone('America/Lima'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSoporte(): ?Soporte
    {
        return $this->soporte;
    }

    public function setSoporte(?Soporte $soporte): static
    {
        $this->soporte = $soporte;

        return $this;
    }

    public function getPago(): ?string
    {
        return $this->pago;
    }

    public function setPago(?string $pago): static
    {
        $this->pago = $pago;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(?\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }
}
