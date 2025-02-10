<?php

namespace App\Entity;

use App\Repository\CaveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CaveRepository::class)]
class Cave
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Wine>
     */
    #[ORM\ManyToMany(targetEntity: Wine::class, inversedBy: 'caves')]
    private Collection $Wine;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function __construct()
    {
        $this->Wine = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Wine>
     */
    public function getWine(): Collection
    {
        return $this->Wine;
    }

    public function addWine(Wine $wine): static
    {
        if (!$this->Wine->contains($wine)) {
            $this->Wine->add($wine);
        }

        return $this;
    }

    public function removeWine(Wine $wine): static
    {
        $this->Wine->removeElement($wine);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
