<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Salud\Webapp\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use SocialApp\Apps\Salud\Webapp\Entity\Traits\EntityTrait;
use SocialApp\Apps\Salud\Webapp\Repository\EnfermedadAsociadaRepository;

#[ORM\Entity(repositoryClass: EnfermedadAsociadaRepository::class)]
#[HasLifecycleCallbacks]
class EnfermedadAsociada
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    public function __toString(): string
    {
        return $this->nombre;
    }

    public function getId(): ?int
    {
        return $this->id;
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
}
