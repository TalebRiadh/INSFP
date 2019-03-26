<?php



namespace App\Entity;


use Symfony\Component\Validator\Constraints as Assert;

class FichierSearch
{
    /**
     * @Assert\Type("string")
     */
    private $module;


    /**
     * @Assert\Type("string")
     */
    private $specialite;

    /**
     * @return string
     */
    public function getModule() : ? string
    {
        return $this->module;
    }

    /**
     * @param string $module
     * @return FichierSearch
     */
    public function setModule(string $module) : FichierSearch
    {
        $this->module = $module;
        return $this;
    }

    /**
     * @return string
     */
    public function getSpecialite() : ? string
    {
        return $this->specialite;
    }

    /**
     * @param string $specialite
     * @return FichierSearch
     */
    public function setSpecialite(string $specialite) : FichierSearch
    {
        $this->specialite = $specialite;
        return $this;
    }

}