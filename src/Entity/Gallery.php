<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass="App\Repository\GalleryRepository")
 */
class Gallery
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
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $chemin;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="photo", fileNameProperty="chemin")
     *
     */
    private $photo;



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


    
    /*---------------------------------------------------------------- */
    public function getId() : ?int
    {
        return $this->id;
    }

    public function getTitre() : ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre) : self
    {
        $this->titre = $titre;

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
    public function getChemin() : ?string
    {
        return $this->chemin;
    }
    /**
     * @param null|string $chemin
     * @return Gallery
     */
    public function setChemin(?string $chemin) : self
    {
        $this->chemin = $chemin;

        return $this;
    }


    /**
     * @return null|File
     */
    public function getPhoto() : ?File
    {
        return $this->photo;
    }

    /**
     * @param null|File $photo
     * @return Gallery
     */
    public function setPhoto(?File $photo) : Gallery
    {
        $this->photo = $photo;

        if ($this->photo instanceof UploadedFile) {
            $this->onPrePersist();
        }
        return $this;
    }
  /**
     * Get $created
     *
     * @return  datetime
     */ 
    public function getCreated()
    {
        return $this->created;
    }

     public function __toString()
    {
        return $this->created;
    }
}


