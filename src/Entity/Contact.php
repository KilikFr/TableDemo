<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact.
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?int $id = null;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private ?string $lastName = null;

    /**
     * @ORM\Column(name="email", type="string", length=255)
     */
    private ?string $email = null;

    /**
     * @ORM\Column(name="mobileNumber", type="string", length=255)
     */
    private ?string $mobileNumber = null;

    /**
     * @ORM\ManyToOne(targetEntity="Organisation",cascade={"persist"}, inversedBy="contacts")
     * @ORM\JoinColumn(name="id_organisation", referencedColumnName="id", nullable=false)
     */
    protected ?Organisation $organisation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setMobileNumber(string $mobileNumber): self
    {
        $this->mobileNumber = $mobileNumber;

        return $this;
    }

    public function getMobileNumber(): ?string
    {
        return $this->mobileNumber;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
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
}
