<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FormationRepository")
 * @UniqueEntity("name")
 */
class Formation
{
   /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="name",type="string", unique=true)
     */
    private $name;



    /**
     *
     * @ORM\Column(name="discription", type="string")
     */
    private $discription;



    public function __construct()
    {
    }

   
    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    public function __toString() {
    return $this->name;
}

    

    /**
     * Get the value of discription
     */ 
    public function getDiscription()
    {
        return $this->discription;
    }

    /**
     * Set the value of discription
     *
     * @return  self
     */ 
    public function setDiscription($discription)
    {
        $this->discription = $discription;

        return $this;
    }
}
