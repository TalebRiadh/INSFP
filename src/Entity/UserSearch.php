<?php



namespace App\Entity;


use Symfony\Component\Validator\Constraints as Assert;

class UserSearch
{
    /**
     * @Assert\Type("string")
     */
    private $nom;


    /**
     * @Assert\Type("string")
     */
    private $tel_num;

    /**
     * @return string
     */
    public function getNom() : ? string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * @return UserSearch
     */
    public function setNom(string $nom) : UserSearch
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelNum() : ? string
    {
        return $this->tel_num;
    }

    /**
     * @param string $tel_num
     * @return UserSearch
     */
    public function setTelNum(string $tel_num) : UserSearch
    {
        $this->tel_num = $tel_num;
        return $this;
    }

}