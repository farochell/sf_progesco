<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   24/12/2019
 * @time  :   15:03
 */

namespace App\Schooling\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Registration
 *
 * @package App\Registration\Entity
 * @ORM\Table(name="registration")
 * @ORM\Entity(repositoryClass="App\Schooling\Repository\RegistrationRepository")
 * @UniqueEntity(
 *     fields={"schoolYear", "student"},
 *     errorPath="student",
 *     message="Cet étudiant est déjà inscrit."
 * )
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Registration
{
    const NOT_VALIDED       = 1;
    const VALIDED           = 2;
    const CANCELED          = 3;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Pedagogy\Entity\SchoolYear")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $schoolYear;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Pedagogy\Entity\Grade")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $grade;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Student\Entity\Student")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $student;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_inscription", type="date")
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $registrationDate;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="has_state_scholarship", type="integer")
     */
    private $hasStateScholarship;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Security\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $userCreation;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Security\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $userModification;
    
    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;
    
    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated;
    
    /**
     * @var \DateTime $updated
     *
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;
    
    private $level;
    
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
    public function getSchoolYear()
    {
        return $this->schoolYear;
    }
    
    /**
     * @param mixed $schoolYear
     */
    public function setSchoolYear($schoolYear): void
    {
        $this->schoolYear = $schoolYear;
    }
    
    /**
     * @return mixed
     */
    public function getGrade()
    {
        return $this->grade;
    }
    
    /**
     * @param mixed $grade
     */
    public function setGrade($grade): void
    {
        $this->grade = $grade;
    }
    
    /**
     * @return mixed
     */
    public function getStudent()
    {
        return $this->student;
    }
    
    /**
     * @param mixed $student
     */
    public function setStudent($student): void
    {
        $this->student = $student;
    }
    
    /**
     * @return \DateTime
     */
    public function getRegistrationDate(): ?\DateTime
    {
        return $this->registrationDate;
    }
    
    /**
     * @param \DateTime $registrationDate
     */
    public function setRegistrationDate(?\DateTime $registrationDate): void
    {
        $this->registrationDate = $registrationDate;
    }
    
    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }
    
    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
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
    public function getUserCreation()
    {
        return $this->userCreation;
    }
    
    /**
     * @param mixed $userCreation
     */
    public function setUserCreation($userCreation): void
    {
        $this->userCreation = $userCreation;
    }
    
    /**
     * @return mixed
     */
    public function getUserModification()
    {
        return $this->userModification;
    }
    
    /**
     * @param mixed $userModification
     */
    public function setUserModification($userModification): void
    {
        $this->userModification = $userModification;
    }
    
    /**
     * Registration constructor.
     */
    public function __construct() {
        $this->status = self::NOT_VALIDED;
        $this->hasStateScholarship = 0;
        $this->registrationDate = new \DateTime('now');
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
     * @return int
     */
    public function getHasStateScholarship(): int
    {
        return $this->hasStateScholarship;
    }
    
    /**
     * @param int $hasStateScholarship
     */
    public function setHasStateScholarship(?int $hasStateScholarship): void
    {
        $this->hasStateScholarship = $hasStateScholarship;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return 'Année scolaire: ' . $this->getSchoolYear()->getLabel() . '- Classe:' . $this->getGrade(
            )->getLabel();
    }
    
}