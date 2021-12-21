<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Organisation.
 *
 * @ORM\Table(name="organisation")
 * @ORM\Entity(repositoryClass="App\Repository\OrganisationRepository")
 */
class Organisation
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private ?string $name = null;

    /**
     * @ORM\Column(name="city", type="string", length=255)
     */
    private ?string $city = null;

    /**
     * @ORM\Column(name="postalCode", type="string", length=255)
     */
    private ?string $postalCode = null;

    /**
     * @ORM\Column(name="countryCode", type="string", length=255)
     */
    private ?string $countryCode = null;

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
     * @ORM\Column(name="startup", type="boolean")
     */
    private bool $startup = false;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function addContact(Contact $contact): self
    {
        $this->contacts[] = $contact;

        return $this;
    }

    public function removeContact(Contact $contact): void
    {
        $this->contacts->removeElement($contact);
    }

    /**
     * @return ArrayCollection|Contact
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    public function setStartup(bool $startup): self
    {
        $this->startup = $startup;

        return $this;
    }

    public function getStartup(): bool
    {
        return $this->startup;
    }

    public function addProduct(Product $product): self
    {
        $this->products[] = $product;

        return $this;
    }

    public function removeProduct(Product $product): void
    {
        $this->products->removeElement($product);
    }

    /**
     * @return ArrayCollection|Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    public function setCountryCode(?string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }
}
