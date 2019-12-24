<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   18/12/2019
 * @time  :   23:34
 */

namespace App\Security\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Role
 *
 * @package App\Security\Entity
 * @ORM\Table(name="role")
 * @ORM\Entity(repositoryClass="App\Security\Repository\RoleRepository")
 * @UniqueEntity("label",message="Ce nom est déjà utilisé pour un autre role")
 * @ORM\HasLifecycleCallbacks()
 */
class Role
{
    const MENU_CONFIGURATION = 1;
    const MENU_ETUDIANT = 2;
    const MENU_GROUPE = 3;
    const MENU_PROFESSEUR = 4;
    const MENU_PAYEMENT = 5;
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
     * @ORM\Column(name="label", type="string", length=100, unique=true)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $label;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     *
     */
    private $description;
    
    /**
     * @var string
     *
     * @ORM\Column(name="menu", type="string")
     *
     */
    private $menu;
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
    
    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }
    
    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    /**
     * @return string
     */
    public function __toString(){
        return $this->label;
    }
    
    /**
     * Get the value of menu
     *
     * @return  string
     */
    public function getMenu()
    {
        return $this->menu;
    }
    
    /**
     * Set the value of menu
     *
     * @param  string  $menu
     *
     * @return  self
     */
    public function setMenu(string $menu)
    {
        $this->menu = $menu;
        
        return $this;
    }
}