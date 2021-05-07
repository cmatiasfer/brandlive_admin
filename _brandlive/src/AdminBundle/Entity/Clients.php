<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Clients
 *
 * @ORM\Table(name="clients")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\ClientsRepository")
 */
class Clients
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
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     * @Assert\Email(
     *     message = "El mail '{{ value }}' no es valido.",
     * )
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     
     * @ORM\Column(name="observation", type="text")
     */
    private $observation;

    /**
     * @ORM\OneToMany(targetEntity="AdminBundle\Entity\ClientsGroups", mappedBy="clients", cascade={"remove"})
     */
    private $clientsGroups;


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
     * @return Clients
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
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Clients
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Clients
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set observation
     *
     * @param string $observation
     *
     * @return Clients
     */
    public function setObservation($observation)
    {
        $this->observation = $observation;

        return $this;
    }

    /**
     * Get observation
     *
     * @return string
     */
    public function getObservation()
    {
        return $this->observation;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->clientsGroups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add usersProject
     *
     * @param \AdminBundle\Entity\ClientsGroups $usersProject
     *
     * @return Clients
     */
    public function addUsersProject(\AdminBundle\Entity\ClientsGroups $clientsGroups)
    {
        $this->clientsGroups[] = $clientsGroups;

        return $this;
    }

    /**
     * Remove usersProject
     *
     * @param \AdminBundle\Entity\ClientsGroups $clientsGroups
     */
    public function removeUsersProject(\AdminBundle\Entity\ClientsGroups $clientsGroups)
    {
        $this->clientsGroups->removeElement($clientsGroups);
    }

    /**
     * Get clientsGroups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClientsGroups()
    {
        return $this->clientsGroups;
    }
}
