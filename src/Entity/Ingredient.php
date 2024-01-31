<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $product = null;

    #[ORM\Column]
    private ?int $weight = null;

    #[ORM\Column(length: 50)]
    private ?string $mass = null;

    #[ORM\ManyToMany(targetEntity: Cake::class, mappedBy: 'ingredient')]
    private Collection $cakes;

    public function __construct()
    {
        $this->cakes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?string
    {
        return $this->product;
    }

    public function setProduct(string $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getMass(): ?string
    {
        return $this->mass;
    }

    public function setMass(string $mass): static
    {
        $this->mass = $mass;

        return $this;
    }

    /**
     * @return Collection<int, Cake>
     */
    public function getCakes(): Collection
    {
        return $this->cakes;
    }

    public function addCake(Cake $cake): static
    {
        if (!$this->cakes->contains($cake)) {
            $this->cakes->add($cake);
            $cake->addIngredient($this);
        }

        return $this;
    }

    public function removeCake(Cake $cake): static
    {
        if ($this->cakes->removeElement($cake)) {
            $cake->removeIngredient($this);
        }

        return $this;
    }
}
