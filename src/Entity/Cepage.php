<?php

namespace App\Entity;

use App\Repository\CepageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CepageRepository::class)]
class Cepage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Wine>
     */
    #[ORM\ManyToMany(targetEntity: Wine::class, mappedBy: 'cepages')]
    private Collection $wine;

    public function __construct()
    {
        $this->wine = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Wine>
     */
    public function getWine(): Collection
    {
        return $this->wine;
    }

    public function addWine(Wine $wine): static
    {
        if (!$this->wine->contains($wine)) {
            $this->wine->add($wine);
            $wine->addCepage($this);
            
        }

        return $this;
    }

    public function removeWine(Wine $wine): static
    {
        if ($this->wine->removeElement($wine)) {
            $wine->removeCepage($this);
        }

        return $this;
    }
}
