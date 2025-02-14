<?php

namespace App\Entity;

use App\Repository\WineRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
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
    private ?Region $region = null;

    /**
     * @var Collection<int, Cepage>
     */
    #[ORM\ManyToMany(targetEntity: Cepage::class, inversedBy: 'wine')]
    private Collection $cepages;

    /**
     * @var Collection<int, Cave>
     */
    #[ORM\ManyToMany(targetEntity: Cave::class, mappedBy: 'Wine')]
    private Collection $caves;

    #[Vich\UploadableField(mapping:'images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

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

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): static
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
        }

        return $this;
    }

    public function removeCepage(Cepage $cepage): static
    {
        $this->cepages->removeElement($cepage);
            
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

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
