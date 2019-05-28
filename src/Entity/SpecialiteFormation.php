<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpecialiteRepository")
 */
class SpecialiteFormation
{
   /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_formation;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_specialite;

   
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
     * Get the value of id_specialite
     */ 
    public function getId_specialite()
    {
        return $this->id_specialite;
    }

    /**
     * Set the value of id_specialite
     *
     * @return  self
     */ 
    public function setId_specialite($id_specialite)
    {
        $this->id_specialite = $id_specialite;

        return $this;
    }

    /**
     * Get the value of id_formation
     */ 
    public function getId_formation()
    {
        return $this->id_formation;
    }

    /**
     * Set the value of id_formation
     *
     * @return  self
     */ 
    public function setId_formation($id_formation)
    {
        $this->id_formation = $id_formation;

        return $this;
    }
}
