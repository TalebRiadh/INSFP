<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass="App\Repository\FichierRepository")
 */
class Fichier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $specialite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $annee;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $semestre;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $createdBy;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $module;


    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $chemin;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="fichier_pdf", fileNameProperty="chemin")
     *
     */
    private $pdfFile;



    /**
     * @var datetime $created
     *
     * @ORM\Column(type="datetime",options={"default":"2014-10-31 08:03:55"})
     */
    protected $created;

    /**
     * @var datetime $updated
     * 
     * @ORM\Column(type="datetime", nullable = true)
     */
    protected $updated;


     public function __toString()
    {
        return $this->specialite;
    }

    
    /*---------------------------------------------------------------- */
    public function getId() : ? int
    {
        return $this->id;
    }

    public function getTitre() : ? string
    {
        return $this->titre;
    }

    public function setTitre(string $titre) : self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getType() : ? string
    {
        return $this->type;
    }

    public function setType(string $type) : self
    {
        $this->type = $type;

        return $this;
    }

    public function getSpecialite() : ? string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite) : self
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getAnnee() : ? string
    {
        return $this->annee;
    }

    public function setAnnee(string $annee) : self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getSemestre() : ? string
    {
        return $this->semestre;
    }

    public function setSemestre(string $semestre) : self
    {
        $this->semestre = $semestre;

        return $this;
    }


    /**
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update

     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated = new \DateTime("now");
    }

    /**
     * @return null|string
     */
    public function getChemin() : ? string
    {
        return $this->chemin;
    }
    /**
     * @param null|string $chemin
     * @return Fichier
     */
    public function setChemin(?string $chemin) : self
    {
        $this->chemin = $chemin;

        return $this;
    }


    /**
     * @return null|File
     */
    public function getPdfFile() : ?File
    {
        return $this->pdfFile;
    }

    /**
     * @param null|File $pdfFile
     * @return Fichier
     */
    public function setPdfFile(?File $pdfFile) : Fichier
    {
        $this->pdfFile = $pdfFile;

        if ($this->pdfFile instanceof UploadedFile) {
            $this->onPrePersist();
        }
        return $this;
    }

function getSlug(): string
    {
        return (new Slugify())->slugify($this->titre);
    }

    /**
     * Get the value of createdBy
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set the value of createdBy
     *
     * @return  self
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get the value of module
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Set the value of module
     *
     * @return  self
     */
    public function setModule($module)
    {
        $this->module = $module;

        return $this;
    }
}


