<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   27/11/2019
 * @time  :   21:18
 */

namespace App\Pedagogy\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Semester
 *
 * @package App\Pedagogy\Entity
 * @ORM\Table(name="semester")
 * @ORM\Entity(repositoryClass="App\Pedagogy\Repository\SemesterRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Semester
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
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=15)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $label;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Pedagogy\Entity\SchoolYear")
     * @ORM\JoinColumn(nullable=false)
     */
    private $schoolyear;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Pedagogy\Entity\Level")
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;
    
    /**
     * @var \Date
     *
     * @ORM\Column(name="start_date", type="date")
     */
    private $startDate;
    
    /**
     * @var \Date
     *
     * @ORM\Column(name="end_date", type="date")
     */
    private $endDate;
    
    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;
    
    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
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
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }
    
    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }
    
    /**
     * @return mixed
     */
    public function getSchoolyear()
    {
        return $this->schoolyear;
    }
    
    /**
     * @param mixed $schoolyear
     */
    public function setSchoolyear($schoolyear): void
    {
        $this->schoolyear = $schoolyear;
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
     * @return \DateTime
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }
    
    /**
     * @param \DateTime $startDate
     */
    public function setStartDate(\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }
    
    /**
     * @return \DateTime
     */
    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }
    
    /**
     * @param \DateTime $endDate
     */
    public function setEndDate(\DateTime $endDate): void
    {
        $this->endDate = $endDate;
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
     * @return string
     */
    public function __toString()
    {
        return $this->label.' ( '.$this->level.' )';
    }
    
    /**
     * Semester constructor.
     */
    public function __construct()
    {
        $this->label     = "";
        $this->startDate = new \DateTime();
        $this->endDate   = new \DateTime();
    }
    
}