<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   18/12/2019
 * @time  :   23:40
 */

namespace App\Security\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Class User
 *
 * @package App\Security\Entity
 * @ORM\Table(name="app_users")
 * @ORM\Entity(repositoryClass="App\Security\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Email déjà utilisé")
 * @UniqueEntity(fields="username", message="Identifiant déjà utilisé")
 */
class User
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank()
     */
    private $username;
    
    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank()
     */
    private $lastName;
    
    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    private $firstName;
    
    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;
    
    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;
    
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;
    
    /**
     * @ORM\ManyToMany(targetEntity="App\Security\Entity\Role",  cascade={"persist"})
     */
    private $roles;
    
    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    
    /**
     *
     */
    public function __construct()
    {
        $this->isActive = true;
        $this->roles = new ArrayCollection();
    }
    
    /**
     * @param $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
    
    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
     * @return null
     */
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }
    
    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * @return array
     */
    public function getRoles()
    {
        $roles = [];
        foreach ($this->roles as $role) {
            $roles[] = $role->getLibelle();
        }
        $roles[] = 'ROLE_USER';
        return $roles;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getRolesObject()
    {
        return $this->roles;
    }
    
    /**
     *
     */
    public function eraseCredentials()
    {
    }
    
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }
    
    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        [
            $this->id,
            $this->username,
            $this->password,
            ] = unserialize($serialized);
    }
    
    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
    
    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }
    
    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
    
    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }
    
    /**
     * @return bool
     */
    public function isAccountNonExpired()
    {
        return true;
    }
    
    /**
     * @return bool
     */
    public function isAccountNonLocked()
    {
        return true;
    }
    
    /**
     * @return bool
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }
    
    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->isActive;
    }
    
    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
    
    
    /**
     * Get the value of lastName
     */
    public function getLastName() : ? string
    {
        return $this->lastName;
    }
    
    /**
     * Set the value of lastName
     *
     * @return  self
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
        
        return $this;
    }
    
    /**
     * Get the value of firstName
     */
    public function getFirstName() : ? string
    {
        return $this->firstName;
    }
    
    /**
     * Set the value of firstName
     *
     * @return  self
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        
        return $this;
    }
    
    /**
     * @param Role $role
     *
     * @return $this
     */
    public function addRole(Role $role): self
    {
        if ($this->roles->contains($role)) {
            return $this;
        }
        $this->roles[] = $role;
        
        return $this;
    }
    
    /**
     * @param Role $role
     *
     * @return $this
     */
    public function removeRole(Role $role): self
    {
        $this->roles->removeElement($role);
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function __toString(){
        return $this->username;
    }
}