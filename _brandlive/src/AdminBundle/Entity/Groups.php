<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groups
 *
 * @ORM\Table(name="groups")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\GroupsRepository")
 */
class Groups
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
     * @ORM\OneToMany(targetEntity="AdminBundle\Entity\ClientsGroups", mappedBy="groups", cascade={"remove"})
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
     * @return Groups
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
     * Constructor
     */
    public function __construct()
    {
        $this->clientsGroups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add clientsGroup
     *
     * @param \AdminBundle\Entity\ClientsGroups $clientsGroup
     *
     * @return Groups
     */
    public function addClientsGroup(\AdminBundle\Entity\ClientsGroups $clientsGroup)
    {
        $this->clientsGroups[] = $clientsGroup;

        return $this;
    }

    /**
     * Remove clientsGroup
     *
     * @param \AdminBundle\Entity\ClientsGroups $clientsGroup
     */
    public function removeClientsGroup(\AdminBundle\Entity\ClientsGroups $clientsGroup)
    {
        $this->clientsGroups->removeElement($clientsGroup);
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
