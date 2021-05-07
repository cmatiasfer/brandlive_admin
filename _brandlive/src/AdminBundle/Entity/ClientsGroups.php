<?php

namespace AdminBundle\Entity;

use AdminBundle\Entity\Clients;
use AdminBundle\Entity\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\ClientsGroupsRepository")
 */
class ClientsGroups
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\Clients", inversedBy="clientsGroups")
     */
    private $clients;

    /**
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\Groups", inversedBy="clientsGroups")
     */
    private $groups;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set clients
     *
     * @param \AdminBundle\Entity\Clients $clients
     *
     * @return ClientsGroups
     */
    public function setClients(\AdminBundle\Entity\Clients $clients = null)
    {
        $this->clients = $clients;

        return $this;
    }

    /**
     * Get clients
     *
     * @return \AdminBundle\Entity\Clients
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * Set groups
     *
     * @param \AdminBundle\Entity\Groups $groups
     *
     * @return ClientsGroups
     */
    public function setGroups(\AdminBundle\Entity\Groups $groups = null)
    {
        $this->groups = $groups;

        return $this;
    }

    /**
     * Get groups
     *
     * @return \AdminBundle\Entity\Groups
     */
    public function getGroups()
    {
        return $this->groups;
    }
}
