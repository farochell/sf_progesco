<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   19/02/2020
 */

namespace App\Pedagogy\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class HourlyVolume
 *
 * @package App\Pedagogy\Entity
 * @ORM\Table(name="hourly_volume")
 * @ORM\Entity(repositoryClass="App\Pedagogy\Repository\HourlyVolumeRepository")
 * @UniqueEntity(
 *     fields={"grade", "semester", "subject"},
 *     errorPath="subject",
 *     message="Volume horaire déjà renseigné"
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class HourlyVolume {
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
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
     * @ORM\ManyToOne(targetEntity="App\Pedagogy\Entity\Semester")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $semester;
    
    /**
     *
     * @var int
     * @ORM\Column(name="total_hours", type="integer")
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $totalHours;
    
    /**
     *
     * @var int
     * @ORM\Column(name="hours_taught", type="integer")
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $hoursTaught;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Pedagogy\Entity\SchoolYear")
     * @ORM\JoinColumn(nullable=false)
     */
    private $schoolYear;
    
    /**
     * @var \DateTime $createdAt
     *
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;
    
    /**
     * @var \DateTime $updatedAt
     *
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;
    
    /**
     * HourlyVolume constructor.
     */
    public function __construct() {
        $this->hoursTaught = 0;
        $this->totalHours = 0;
    }
    
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
     * @return int
     */
    public function getTotalHours(): int {
        return $this->totalHours;
    }
    
    /**
     * @param int $totalHours
     */
    public function setTotalHours(int $totalHours): void {
        $this->totalHours = $totalHours;
    }
    
    /**
     * @return int
     */
    public function getHoursTaught(): int {
        return $this->hoursTaught;
    }
    
    /**
     * @param int $hoursTaught
     */
    public function setHoursTaught(int $hoursTaught): void {
        $this->hoursTaught = $hoursTaught;
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
     * @return mixed
     */
    public function getSchoolYear() {
        return $this->schoolYear;
    }
    
    /**
     * @param mixed $schoolYear
     */
    public function setSchoolYear($schoolYear): void {
        $this->schoolYear = $schoolYear;
    }
    
}