<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   10/12/2019
 * @time  :   13:27
 */

namespace App\Teacher\Entity;

use App\Pedagogy\Entity\Speciality;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Teacher
 *
 * @package App\Teacher\Entity
 * @ORM\Table(name="teacher")
 * @ORM\Entity(repositoryClass="App\Teacher\Repository\TeacherRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Teacher
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
     * @ORM\Column(name="lastname", type="string", length=30)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $lastname;
    
    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $firstname;
    
    /**
     * @var string
     *
     * @ORM\Column(name="matricule", type="string", length=30, nullable=true)
     *
     */
    private $matricule;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birth_date", type="date", nullable=true)
     */
    private $birthDate;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nationality", type="string", length=20, nullable=true)
     */
    private $nationality;
    
    /**
     * @var string
     *
     * @ORM\Column(name="study_level", type="string", length=20, nullable=true)
     */
    private $studyLevel;
    
    /**
     * @var string
     *
     * @ORM\Column(name="phone1", type="string", length=20)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $phone1;
    
    /**
     * @var string
     *
     * @ORM\Column(name="phone2", type="string", length=20, nullable=true)
     */
    private $phone2;
    
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=true)
     */
    private $email;
    
    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text", nullable=true)
     */
    private $address;
    
    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=30, nullable=true)
     */
    private $city;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    
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
    
    /**
     * @ORM\ManyToMany(targetEntity="App\Pedagogy\Entity\Speciality", cascade={"persist"})
     */
    private $specialities;
    
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
    public function getLastname(): ?string
    {
        return $this->lastname;
    }
    
    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }
    
    /**
     * @return string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }
    
    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }
    
    /**
     * @return string
     */
    public function getMatricule(): ?string
    {
        return $this->matricule;
    }
    
    /**
     * @param string $matricule
     */
    public function setMatricule(string $matricule): void
    {
        $this->matricule = $matricule;
    }
    
    /**
     * @return \DateTime
     */
    public function getBirthDate(): ?\DateTime
    {
        return $this->birthDate;
    }
    
    /**
     * @param \DateTime $birthDate
     */
    public function setBirthDate(\DateTime $birthDate): void
    {
        $this->birthDate = $birthDate;
    }
    
    /**
     * @return string
     */
    public function getNationality(): ?string
    {
        return $this->nationality;
    }
    
    /**
     * @param string $nationality
     */
    public function setNationality(string $nationality): void
    {
        $this->nationality = $nationality;
    }
    
    /**
     * @return string
     */
    public function getStudyLevel(): ?string
    {
        return $this->studyLevel;
    }
    
    /**
     * @param string $studyLevel
     */
    public function setStudyLevel(string $studyLevel): void
    {
        $this->studyLevel = $studyLevel;
    }
    
    /**
     * @return string
     */
    public function getPhone1(): ?string
    {
        return $this->phone1;
    }
    
    /**
     * @param string $phone1
     */
    public function setPhone1(string $phone1): void
    {
        $this->phone1 = $phone1;
    }
    
    /**
     * @return string
     */
    public function getPhone2(): ?string
    {
        return $this->phone2;
    }
    
    /**
     * @param string $phone2
     */
    public function setPhone2(string $phone2): void
    {
        $this->phone2 = $phone2;
    }
    
    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }
    
    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    
    /**
     * @return string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }
    
    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }
    
    /**
     * @return string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }
    
    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }
    
    /**
     * @return bool
     */
    public function isActive(): ?bool
    {
        return $this->isActive;
    }
    
    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
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
    public function getSpecialities()
    {
        return $this->specialities;
    }
    
    /**
     * @param Speciality $speciality
     *
     * @return $this
     */
    public function addSpeciality(Speciality $speciality)
    {
        $this->specialities[] = $speciality;
        
        return $this;
    }
    
    /**
     * @param Speciality $speciality
     */
    public function removeSpeciality(Speciality $speciality)
    {
        $this->specialities->removeElement($speciality);
    }
    
    /**
     * Teacher constructor.
     */
    public function __construct()
    {
        $this->lastname     = "";
        $this->firstname    = "";
        $this->nationality  = "";
        $this->isActive     = true;
        $this->specialities = new ArrayCollection();
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->firstname.' '.$this->lastname.' ( '.$this->matricule.')';
    }
    
    
}