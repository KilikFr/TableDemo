<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Product\Category;

/**
 * Product.
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity="Organisation",cascade={"persist"}, inversedBy="products")
     * @ORM\JoinColumn(name="id_organisation", referencedColumnName="id", nullable=false)
     */
    protected ?Organisation $organisation = null;

    /**
     * @ORM\Column(name="gtin", type="string", length=20, nullable=true)
     */
    private ?string $gtin = null;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private ?string $name = null;

    /**
     * @ORM\Column(name="price", type="decimal", precision=7, scale=3)
     */
    private ?string $price = null;

    /**
     * @ORM\Column(name="stock_quantity", type="integer")
     */
    private int $stockQuantity = 0;

    /**
     * @ORM\Column(name="creation_date_time", type="datetime")
     */
    private ?\DateTime $creationDateTime = null;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Product\Category",cascade={"persist"})
     * @ORM\JoinColumn(name="id_category", referencedColumnName="id", nullable=true)
     */
    protected ?Category $category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setOrganisation(Organisation $organisation): self
    {
        $this->organisation = $organisation;

        return $this;
    }

    public function getOrganisation(): ?Organisation
    {
        return $this->organisation;
    }

    public function setGtin(string $gtin): self
    {
        $this->gtin = $gtin;

        return $this;
    }

    public function getGtin(): ?string
    {
        return $this->gtin;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setStockQuantity(int $stockQuantity): self
    {
        $this->stockQuantity = $stockQuantity;

        return $this;
    }

    public function getStockQuantity(): int
    {
        return $this->stockQuantity;
    }

    public function setCreationDateTime(\DateTime $creationDateTime): self
    {
        $this->creationDateTime = $creationDateTime;

        return $this;
    }

    public function getCreationDateTime(): ?\DateTime
    {
        return $this->creationDateTime;
    }

    public function setCategory(Category $category = null): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }
}
