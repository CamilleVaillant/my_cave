<?php

namespace App\Entity;

use App\Repository\WineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WineRepository::class)]
class Wine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column(length: 255)]
    private ?string $body = null;

    #[ORM\ManyToOne(inversedBy: 'wines')]
    private ?region $region = null;

    /**
     * @var Collection<int, Cepage>
     */
    #[ORM\ManyToMany(targetEntity: Cepage::class, mappedBy: 'wine')]
    private Collection $cepages;

    /**
     * @var Collection<int, Cave>
     */
    #[ORM\ManyToMany(targetEntity: Cave::class, mappedBy: 'Wine')]
    private Collection $caves;

    public function __construct()
    {
        $this->cepages = new ArrayCollection();
        $this->caves = new ArrayCollection();
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

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function getRegion(): ?region
    {
        return $this->region;
    }

    public function setRegion(?region $region): static
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return Collection<int, Cepage>
     */
    public function getCepages(): Collection
    {
        return $this->cepages;
    }

    public function addCepage(Cepage $cepage): static
    {
        if (!$this->cepages->contains($cepage)) {
            $this->cepages->add($cepage);
            $cepage->addWine($this);
        }

        return $this;
    }

    public function removeCepage(Cepage $cepage): static
    {
        if ($this->cepages->removeElement($cepage)) {
            $cepage->removeWine($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Cave>
     */
    public function getCaves(): Collection
    {
        return $this->caves;
    }

    public function addCave(Cave $cave): static
    {
        if (!$this->caves->contains($cave)) {
            $this->caves->add($cave);
            $cave->addWine($this);
        }

        return $this;
    }

    public function removeCave(Cave $cave): static
    {
        if ($this->caves->removeElement($cave)) {
            $cave->removeWine($this);
        }

        return $this;
    }
}
