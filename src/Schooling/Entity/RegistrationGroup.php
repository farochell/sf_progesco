<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   01/02/2020
 * @time  :   22:56
 */

namespace App\Schooling\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RegistrationGroup
 *
 * @package App\Schooling\Entity
 * @ORM\Entity(repositoryClass="App\Schooling\Repository\RegistrationGroupRepository")
 * @ORM\Table(name="registration_group")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"registration", "group"},
 *     errorPath="registration",
 *     message="Cet étudiant est déjà inscrit."
 * )
 */
class RegistrationGroup {
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Pedagogy\Entity\Group", inversedBy="registrationgroups")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $group;
    
    /**
     * @ORM\OneToOne(targetEntity="App\Schooling\Entity\Registration")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $registration;
    
    /**
     * @var \DateTime $createdAt
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;
    
    /**
     * @var \DateTime $updatedAt
     *
     * @ORM\Column(name="updateAt", type="datetime", nullable=true)
     */
    private $updatedAt;
    
    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }
    
    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }
    
    /**
     * @return mixed
     */
    public function getGroup() {
        return $this->group;
    }
    
    /**
     * @param mixed $group
     */
    public function setGroup($group): void {
        $this->group = $group;
    }
    
    /**
     * @return mixed
     */
    public function getRegistration() {
        return $this->registration;
    }
    
    /**
     * @param mixed $registration
     */
    public function setRegistration($registration): void {
        $this->registration = $registration;
    }
    
    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime {
        return $this->createdAt;
    }
    
    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void {
        $this->createdAt = $createdAt;
    }
    
    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime {
        return $this->updatedAt;
    }
    
    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void {
        $this->updatedAt = $updatedAt;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }
    
}