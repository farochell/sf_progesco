<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/02/2020
 * @time  :   10:57
 */

namespace App\Scoring\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Class ClassNote
 *
 * @package App\Scoring\Entity
 * @ORM\Table(name="class_note")
 * @ORM\Entity(repositoryClass="App\Scoring\Repository\ClassNoteRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ClassNote {
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
     * @ORM\Column(name="label", type="string", length=20)
     */
    private $label;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Scoring\Entity\TypeOfRating")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $typeOfRating;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Pedagogy\Entity\Semester")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $semester;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Teacher\Entity\Teacher")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $teacher;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Pedagogy\Entity\Subject")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $subject;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Pedagogy\Entity\Grade")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $grade;
    
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
     * @return mixed
     */
    public function getTypeOfRating() {
        return $this->typeOfRating;
    }
    
    /**
     * @param mixed $typeOfRating
     */
    public function setTypeOfRating($typeOfRating): void {
        $this->typeOfRating = $typeOfRating;
    }
    
    /**
     * @return mixed
     */
    public function getSemester() {
        return $this->semester;
    }
    
    /**
     * @param mixed $semester
     */
    public function setSemester($semester): void {
        $this->semester = $semester;
    }
    
    /**
     * @return mixed
     */
    public function getTeacher() {
        return $this->teacher;
    }
    
    /**
     * @param mixed $teacher
     */
    public function setTeacher($teacher): void {
        $this->teacher = $teacher;
    }
    
    /**
     * @return mixed
     */
    public function getSubject() {
        return $this->subject;
    }
    
    /**
     * @param mixed $subject
     */
    public function setSubject($subject): void {
        $this->subject = $subject;
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
    
    /**
     * @return string
     */
    public function getLabel(): ?string {
        return $this->label;
    }
    
    /**
     * @param string $label
     */
    public function setLabel(string $label): void {
        $this->label = $label;
    }
    
    /**
     * @return mixed
     */
    public function getGrade() {
        return $this->grade;
    }
    
    /**
     * @param mixed $grade
     */
    public function setGrade($grade): void {
        $this->grade = $grade;
    }
    
    /**
     * @return string
     */
    public function __toString() {
        return $this->label;
    }
}