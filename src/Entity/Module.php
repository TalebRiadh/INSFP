<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModuleRepository")
 */
class Module
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
        * @ORM\Column(type="integer")
     */
    private $specialite_id;

    public function getId()
    {
        return $this->id;
    }
  public function __toString() {
    return $this->nom;
}
    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }


    /**
     * Get the value of specialite_id
     */ 
    public function getSpecialite_id()
    {
        return $this->specialite_id;
    }

    /**
     * Set the value of specialite_id
     *
     * @return  self
     */ 
    public function setSpecialite_id($specialite_id)
    {
        $this->specialite_id = $specialite_id;

        return $this;
    }
}
