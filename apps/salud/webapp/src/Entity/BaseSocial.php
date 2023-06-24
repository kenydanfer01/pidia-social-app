<?php

namespace SocialApp\Apps\Salud\Webapp\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use SocialApp\Apps\Salud\Webapp\Entity\Traits\EntityTrait;
use SocialApp\Apps\Salud\Webapp\Repository\BaseSocialRepository;

#[ORM\Entity(repositoryClass: BaseSocialRepository::class)]
#[HasLifecycleCallbacks]
class BaseSocial
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nombre = null;

    #[ORM\Column(length: 100)]
    private ?string $localidad = null;

    #[ORM\OneToMany(mappedBy: 'baseSocial', targetEntity: Paciente::class)]
    private Collection $asociados;

    public function __construct()
    {
        $this->asociados = new ArrayCollection();
    }

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

    public function getLocalidad(): ?string
    {
        return $this->localidad;
    }

    public function setLocalidad(string $localidad): static
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * @return Collection<int, Paciente>
     */
    public function getAsociados(): Collection
    {
        return $this->asociados;
    }

    public function addAsociado(Paciente $asociado): static
    {
        if (!$this->asociados->contains($asociado)) {
            $this->asociados->add($asociado);
            $asociado->setBaseSocial($this);
        }

        return $this;
    }

    public function removeAsociado(Paciente $asociado): static
    {
        if ($this->asociados->removeElement($asociado)) {
            // set the owning side to null (unless already changed)
            if ($asociado->getBaseSocial() === $this) {
                $asociado->setBaseSocial(null);
            }
        }

        return $this;
    }
}
