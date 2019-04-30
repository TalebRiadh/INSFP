<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
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
    private $mFrom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mTo;

    /**
     * @ORM\Column(type="text")
     */
    private $container;

    
    /**
     * @var datetime $created
     *
     * @ORM\Column(type="datetime")
     */
    protected $created;


     /**
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMFrom(): ?string
    {
        return $this->mFrom;
    }

    public function setMFrom(string $mFrom): self
    {
        $this->mFrom = $mFrom;

        return $this;
    }

    public function getMTo(): ?string
    {
        return $this->mTo;
    }

    public function setMTo(string $mTo): self
    {
        $this->mTo = $mTo;

        return $this;
    }

    public function getContainer(): ?string
    {
        return $this->container;
    }

    public function setContainer(string $container): self
    {
        $this->container = $container;

        return $this;
    }
}
