<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   08/02/2020
 * @time  :   12:27
 */

namespace App\Scoring\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class ClassNoteForm
 *
 * @package App\Scoring\Entity
 * @ORM\Table(name="class_note_form")
 * @ORM\Entity(repositoryClass="App\Scoring\Repository\ClassNoteFormRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ClassNoteForm {
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float")
     */
    private $value;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Scoring\Entity\ClassNote")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $classNote;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Schooling\Entity\Registration")
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
     * @ORM\Column(type="datetime", nullable=true)
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
     * @return float
     */
    public function getValue(): float {
        return $this->value;
    }
    
    /**
     * @param float $value
     */
    public function setValue(float $value): void {
        $this->value = $value;
    }
    
    /**
     * @return mixed
     */
    public function getClassNote() {
        return $this->classNote;
    }
    
    /**
     * @param mixed $classNote
     */
    public function setClassNote($classNote): void {
        $this->classNote = $classNote;
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
    public function setCreatedAtValue() {
        $this->createdAt = new \DateTime();
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue() {
        $this->updatedAt = new \DateTime();
    }
}