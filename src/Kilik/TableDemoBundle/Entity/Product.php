<?php

namespace Kilik\TableDemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kilik\TableDemoBundle\Entity\Product\Category;

/**
 * Product.
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="Kilik\TableDemoBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Organisation
     *
     * @ORM\ManyToOne(targetEntity="Organisation",cascade={"persist"}, inversedBy="products")
     * @ORM\JoinColumn(name="id_organisation", referencedColumnName="id", nullable=false)
     */
    protected $organisation;

    /**
     * @var string
     *
     * @ORM\Column(name="gtin", type="string", length=20, nullable=true)
     */
    private $gtin;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=7, scale=3)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="stock_quantity", type="integer")
     */
    private $stockQuantity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date_time", type="datetime")
     */
    private $creationDateTime;


    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="\Kilik\TableDemoBundle\Entity\Product\Category",cascade={"persist"})
     * @ORM\JoinColumn(name="id_category", referencedColumnName="id", nullable=true)
     */
    protected $category;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set organisation.
     *
     * @param Organisation $organisation
     *
     * @return Product
     */
    public function setOrganisation(Organisation $organisation)
    {
        $this->organisation = $organisation;

        return $this;
    }

    /**
     * Get organisation.
     *
     * @return static
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }

    /**
     * Set gtin.
     *
     * @param string $gtin
     *
     * @return Product
     */
    public function setGtin($gtin)
    {
        $this->gtin = $gtin;

        return $this;
    }

    /**
     * Get gtin.
     *
     * @return string
     */
    public function getGtin()
    {
        return $this->gtin;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price.
     *
     * @param string $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set stockQuantity.
     *
     * @param int $stockQuantity
     *
     * @return Product
     */
    public function setStockQuantity($stockQuantity)
    {
        $this->stockQuantity = $stockQuantity;

        return $this;
    }

    /**
     * Get stockQuantity.
     *
     * @return int
     */
    public function getStockQuantity()
    {
        return $this->stockQuantity;
    }

    /**
     * Set creationDateTime.
     *
     * @param \DateTime $creationDateTime
     *
     * @return Product
     */
    public function setCreationDateTime(\DateTime $creationDateTime)
    {
        $this->creationDateTime = $creationDateTime;

        return $this;
    }

    /**
     * Get creationDateTime.
     *
     * @return \DateTime
     */
    public function getCreationDateTime()
    {
        return $this->creationDateTime;
    }

    /**
     * Set category
     *
     * @param \Kilik\TableDemoBundle\Entity\Product\Category $category
     *
     * @return Product
     */
    public function setCategory(\Kilik\TableDemoBundle\Entity\Product\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Kilik\TableDemoBundle\Entity\Product\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
