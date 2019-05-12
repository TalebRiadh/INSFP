<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *     fields={"email"},
 *     message="l'email que vous avez indiqué est deja utilisé"
 * )
 * @UniqueEntity(
 *     fields= {"tel_num"},
 *      message="le numero de telephone que vous avez indiqué est deja utilisé "
 * )
 */
class User implements UserInterface, \Serializable
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    public function __toString() {
    return $this->email;
}
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tel_num;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8",minMessage="votre mot de passe doit faire minimum 8 caracteres")
     */
    private $password;

    /**
     * @var string
     * @Assert\EqualTo(propertyPath="password", message="Vous n'avez pas tapé le meme mot de passe")
     *
     */
    public $confirm_password;

    /**
     * @ORM\Column(type="integer")
     */
    private $role;

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


    /*----------- getters and setters ----------------------------*/

    public function getId() : ? int
    {
        return $this->id;
    }

    public function getNom() : ? string
    {
        return $this->nom;
    }

    public function setNom(string $nom) : self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom() : ? string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom) : self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail() : ? string
    {
        return $this->email;
    }

    public function setEmail(string $email) : self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelNum() : ? string
    {
        return $this->tel_num;
    }

    public function setTelNum(string $tel_num) : self
    {
        $this->tel_num = $tel_num;

        return $this;
    }

    public function getPassword() : ? string
    {
        return $this->password;
    }

    public function setPassword(string $password) : self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole() : ? int
    {
        return $this->role;
    }
    private $roles = [];
    public function getRoles() : array
    {
        $roles = $this->roles;
        if ($this->role === 0 ) {
            $roles[] = 'ROLE_ADMIN';
        } else {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }
    public function setRole(int $role) : self
    {
        $this->role = $role;

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
   /*---------- OVERRIDING ---------------*/

    public function getSalt()
    {
          return '';
    }

    public function eraseCredentials()
    {
    }


    public function getUsername() : ? string
    {
        return $this->tel_num;
    }

    public function setUsername(string $tel_num) : self
    {
        $this->tel_num = $tel_num;

        return $this;
    }

    /*-----------------------------------------------*/


    /**
     * String representation of object
     * @link https://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize(
            [
                $this->id,
                $this->tel_num,
                $this->password
            ]
        );
    }

    /**
     * Constructs the object
     * @link https://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->tel_num,
            $this->password
        ) = unserialize($serialized, ['allowed_classes' => false]);
    }


}
