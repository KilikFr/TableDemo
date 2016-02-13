<?php

namespace Kilik\TableDemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
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
     * @ORM\Column(name="price", type="decimal", precision=5, scale=3)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="stockQuantity", type="integer")
     */
    private $stockQuantity;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set organisation
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
     * Get organisation
     *
     * @return \stdClass
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }

    /**
     * Set gtin
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
     * Get gtin
     *
     * @return string
     */
    public function getGtin()
    {
        return $this->gtin;
    }

    /**
     * Set name
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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
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
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set stockQuantity
     *
     * @param integer $stockQuantity
     *
     * @return Product
     */
    public function setStockQuantity($stockQuantity)
    {
        $this->stockQuantity = $stockQuantity;

        return $this;
    }

    /**
     * Get stockQuantity
     *
     * @return int
     */
    public function getStockQuantity()
    {
        return $this->stockQuantity;
    }

}
