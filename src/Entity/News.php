<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * News
 *
 * @ORM\Table(name="News")
 * @ORM\Entity(repositoryClass="App\Repository\NewsRepository")
 */
class News
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var text
     *
     * @ORM\Column(name="discription", type="text")
     */
    private $discription;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;


    /**
     *  @ORM\Column(type="datetime",nullable = true)
     */
    private $date_de_evenement;

    
    /**
     *  @ORM\Column(type="datetime",nullable = true)
     */
    private $start;

    
    /**
     *  @ORM\Column(type="datetime",nullable = true)
     */
    private $end;

    /**
     * @ORM\ManyToMany(targetEntity="Files", cascade={"persist"})
     */
    private $files;

    /**
     * @var datetime $created
     *
     * @ORM\Column(type="datetime")
     */
    protected $created;
/**
     * @var datetime $updated
     * 
     * @ORM\Column(type="datetime", nullable = true)
     */
    protected $updated;

 /**
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
    }

    function getSlug(): string
    {
        return (new Slugify())->slugify($this->titre);
    }

    /**
     * Gets triggered every time on update

     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated = new \DateTime("now");
    }

    function __construct()
    {
        $this->files = new ArrayCollection();
    }

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
     * @param string $titre
     *
     * @return User
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    public function setType(string $type) : self
    {
        $this->type = $type;

        return $this;
    }

    public function getType() : ? string
    {
        return $this->type;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set discription
     *
     * @param string $discription
     *
     * @return User
     */
    public function setDiscription($discription)
    {
        $this->discription = $discription;

        return $this;
    }

    /**
     * Get discription
     *
     * @return string
     */
    public function getDiscription()
    {
        return $this->discription;
    }

    /**
     * Get files
     * 
     * @return ArrayCollection
     */
    function getFiles()
    {
        return $this->files;
    }

    /**
     * Set files
     * @param type $files
     */
    function setFiles($files)
    {
        $this->files = $files;
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

    /**
     * Get the value of date_de_evenement
     */ 
    public function getDateDeEvenement()
    {
        return $this->date_de_evenement;
    }

    /**
     * Set the value of date_de_evenement
     *
     * @return  self
     */ 
    public function setDateDeEvenement($date_de_evenement)
    {
        $this->date_de_evenement = $date_de_evenement;

        return $this;
    }

    /**
     * Get the value of start
     */ 
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set the value of start
     *
     * @return  self
     */ 
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get the value of end
     */ 
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set the value of end
     *
     * @return  self
     */ 
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }
}
