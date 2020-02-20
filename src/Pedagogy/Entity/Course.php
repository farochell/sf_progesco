<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   23/11/2019
 * @time  :   17:01
 */

namespace App\Pedagogy\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Course
 *
 * @package App\Pedagogy\Entity
 * @ORM\Table(name="course")
 * @ORM\Entity(repositoryClass="App\Pedagogy\Repository\CourseRepository")
 *
 */
class Course
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToMany(targetEntity="App\Pedagogy\Entity\Group", cascade={"persist"})
     */
    private $groups;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Pedagogy\Entity\Subject")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subject;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Classroom\Entity\Classroom")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classroom;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Teacher\Entity\Teacher")
     * @ORM\JoinColumn(nullable=true)
     */
    private $teacher;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Pedagogy\Entity\Semester")
     * @ORM\JoinColumn(nullable=false)
     */
    private $semester;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="course_date", type="date")
     */
    private $courseDate;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_hour", type="time")
     */
    private $startHour;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_hour", type="time")
     */
    private $endHour;
    
    /**
     * @var Boolean
     *
     * @ORM\Column(name="is_valid", type="boolean")
     */
    private $isValid;
    
    private $periodicite;
    
    private $level;
    
    /**
     * @var \DateTime $created
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;
    
    /**
     * @var \DateTime $updated
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated;
    
    /**
     * @var \DateTime $updated
     *
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    
    /**
     * @return mixed
     */
    public function getGroups()
    {
        return $this->groups;
    }
    
    /**
     * @param Group $group
     *
     * @return $this
     */
    public function addGroup(Group $group) {
        $this->groups[] = $group;
        return $this;
    }
    
    /**
     * @param Group $group
     */
    public function removeGroup(Group $group) {
        $this->groups->removeElement($group);
    }
    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }
    
    /**
     * @param mixed $subject
     */
    public function setSubject($subject): void
    {
        $this->subject = $subject;
    }
    
    /**
     * @return \DateTime
     */
    public function getCourseDate(): ?\DateTime
    {
        return $this->courseDate;
    }
    
    /**
     * @param \DateTime $courseDate
     */
    public function setCourseDate(?\DateTime $courseDate): void
    {
        $this->courseDate = $courseDate;
    }
    
    /**
     * @return \DateTime
     */
    public function getStartHour(): ?\DateTime
    {
        return $this->startHour;
    }
    
    /**
     * @param \DateTime $startHour
     */
    public function setStartHour(?\DateTime $startHour): void
    {
        $this->startHour = $startHour;
    }
    
    /**
     * @return \DateTime
     */
    public function getEndHour(): ?\DateTime
    {
        return $this->endHour;
    }
    
    /**
     * @param \DateTime $endHour
     */
    public function setEndHour(?\DateTime $endHour): void
    {
        $this->endHour = $endHour;
    }
    
    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }
    
    /**
     * @param bool $isValid
     */
    public function setIsValid(bool $isValid): void
    {
        $this->isValid = $isValid;
    }
    
    /**
     * @return mixed
     */
    public function getPeriodicite()
    {
        return $this->periodicite;
    }
    
    /**
     * @param mixed $periodicite
     */
    public function setPeriodicite($periodicite): void
    {
        $this->periodicite = $periodicite;
    }
    
    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }
    
    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created): void
    {
        $this->created = $created;
    }
    
    /**
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }
    
    /**
     * @param \DateTime $updated
     */
    public function setUpdated(\DateTime $updated): void
    {
        $this->updated = $updated;
    }
    
    /**
     * @return \DateTime
     */
    public function getDeletedAt(): \DateTime
    {
        return $this->deletedAt;
    }
    
    /**
     * @param \DateTime $deletedAt
     */
    public function setDeletedAt(\DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
    
    /**
     * @return mixed
     */
    public function getClassroom()
    {
        return $this->classroom;
    }
    
    /**
     * @param mixed $classroom
     */
    public function setClassroom($classroom): void
    {
        $this->classroom = $classroom;
    }
    
    /**
     * @return mixed
     */
    public function getSemester()
    {
        return $this->semester;
    }
    
    /**
     * @param mixed $semester
     */
    public function setSemester($semester): void
    {
        $this->semester = $semester;
    }
    
    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }
    
    /**
     * @param mixed $level
     */
    public function setLevel($level): void
    {
        $this->level = $level;
    }
    
    /**
     * @return mixed
     */
    public function getTeacher()
    {
        return $this->teacher;
    }
    
    /**
     * @param mixed $teacher
     */
    public function setTeacher($teacher): void
    {
        $this->teacher = $teacher;
    }
    
    /**
     * Course constructor.
     */
    public function __construct() {
        $this->isValid = 0;
        $this->groups = new ArrayCollection();
    }
    
}