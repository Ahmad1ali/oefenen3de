<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Category $category = null;

    /**
     * @var Collection<int, PurchaseLine>
     */
    #[ORM\OneToMany(targetEntity: PurchaseLine::class, mappedBy: 'product')]
    private Collection $purchaseLines;

    public function __construct()
    {
        $this->purchaseLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, PurchaseLine>
     */
    public function getPurchaseLines(): Collection
    {
        return $this->purchaseLines;
    }

    public function addPurchaseLine(PurchaseLine $purchaseLine): static
    {
        if (!$this->purchaseLines->contains($purchaseLine)) {
            $this->purchaseLines->add($purchaseLine);
            $purchaseLine->setProduct($this);
        }

        return $this;
    }

    public function removePurchaseLine(PurchaseLine $purchaseLine): static
    {
        if ($this->purchaseLines->removeElement($purchaseLine)) {
            // set the owning side to null (unless already changed)
            if ($purchaseLine->getProduct() === $this) {
                $purchaseLine->setProduct(null);
            }
        }

        return $this;
    }
}
