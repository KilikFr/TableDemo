<?php

namespace Kilik\TableDemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Organisation
 *
 * @ORM\Table(name="organisation")
 * @ORM\Entity(repositoryClass="Kilik\TableDemoBundle\Repository\OrganisationRepository")
 */
class Organisation
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="postalCode", type="string", length=255)
     */
    private $postalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="countryCode", type="string", length=255)
     */
    private $countryCode;
    
    /**
     * @var ArrayCollection|Contact
     * @ORM\OneToMany(
     *     targetEntity="Contact",
     *     mappedBy="organisation",
     *     cascade={"persist"}
     * )  
     */
    private $contacts;

    /**
     * @var ArrayCollection|Product
     * @ORM\OneToMany(
     *     targetEntity="Product",
     *     mappedBy="organisation",
     *     cascade={"persist"}
     * )  
     */
    private $products;

    /**
     * @var bool
     *
     * @ORM\Column(name="startup", type="boolean")
     */
    private $startup=false;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Organisation
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
     * Set city
     *
     * @param string $city
     *
     * @return Organisation
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     *
     * @return Organisation
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Add contact
     *
     * @param Contact $contact
     *
     * @return Organisation
     */
    public function addContact(Contact $contact)
    {
        $this->contacts[] = $contact;

        return $this;
    }

    /**
     * Remove contact
     *
     * @param Contact $contact
     */
    public function removeContact(Contact $contact)
    {
        $this->contacts->removeElement($contact);
    }

    /**
     * Get contacts
     *
     * @return ArrayCollection|Contact
     */
    public function getContacts()
    {
        return $this->contacts;
    }


    /**
     * Set startup
     *
     * @param boolean $startup
     *
     * @return Organisation
     */
    public function setStartup($startup)
    {
        $this->startup = $startup;

        return $this;
    }

    /**
     * Get startup
     *
     * @return boolean
     */
    public function getStartup()
    {
        return $this->startup;
    }

    /**
     * Add product
     *
     * @param \Kilik\TableDemoBundle\Entity\Product $product
     *
     * @return Organisation
     */
    public function addProduct(\Kilik\TableDemoBundle\Entity\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \Kilik\TableDemoBundle\Entity\Product $product
     */
    public function removeProduct(\Kilik\TableDemoBundle\Entity\Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }
}
