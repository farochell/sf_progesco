<?php


namespace App\Student\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Student
 * @package App\Student\Entity
 * emile.camara
 * 16/11/2019
 *
 * @ORM\Table(name="student")
 * @ORM\Entity(repositoryClass="App\Student\Repository\StudentRepository")
 * @UniqueEntity("matricule",message="Ce matricule est déjà attribué")
 */
class Student
{
    /**
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     *
     * @ORM\Column(name="lastname", type="string", length=30)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $lastname;
    
    /**
     *
     * @ORM\Column(name="firstname", type="string", length=30)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $firstname;
    
    /**
     *
     * @ORM\Column(name="birth_date", type="date")
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $birthDate;
    
    /**
     *
     * @var string
     * @ORM\Column(name="birth_place", type="string", length=30)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $birthPlace;
    
    /**
     *
     * @ORM\Column(name="matricule", type="string", length=30,
     *      nullable=true)
     *
     */
    private $matricule;
    
    /**
     *
     * @var \DateTime
     * @ORM\Column(name="registration_date", type="date")
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $registrationDate;
    
    /**
     *
     * @var string
     * @ORM\Column(name="address", type="text")
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $address;
    
    /**
     *
     * @var string
     * @ORM\Column(name="email", type="string", length=100,
     *      nullable=true, unique=true)
     */
    private $email;
    
    /**
     *
     * @var string
     * @ORM\Column(name="phone", type="string", length=50,
     *      nullable=true)
     */
    private $phone;
    
    /**
     *
     * @var string
     * @ORM\Column(name="father_lastname", type="string", length=30)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $fatherLastname;
    
    /**
     *
     * @var string @ORM\Column(name="father_firstname", type="string", length=30)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $fatherFirstname;
    
    /**
     *
     * @var string @ORM\Column(name="mother_lastname", type="string", length=30)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $motherLastname;
    
    /**
     *
     * @var string @ORM\Column(name="mother_firstname", type="string", length=30)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $motherFirstname;
    
    /**
     *
     * @var string
     * @ORM\Column(name="father_profession", type="string", length=50)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $fatherProfession;
    
    /**
     *
     * @var string
     * @ORM\Column(name="mother_profession", type="string", length=50)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $motherProfession;
    
    /**
     *
     * @var int
     * @ORM\Column(name="nb_child", type="integer")
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $nbChild;
    
    /**
     *
     * @var string @ORM\Column(name="guardian_lasname", type="string", length=50)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $guardianLastname;
    
    /**
     *
     * @var string @ORM\Column(name="guardian_firstname", type="string", length=50)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $guardianFirstname;
    
    /**
     *
     * @var string @ORM\Column(name="guardian_address", type="text")
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $guardianAddress;
    
    /**
     *
     * @var string @ORM\Column(name="guardian_phone1", type="string", length=50,
     *      nullable=true)
     */
    private $guardianPhone1;
    
    /**
     *
     * @var string @ORM\Column(name="guardian_phone2", type="string", length=50,
     *      nullable=true)
     */
    private $guardianPhone2;
    
    /**
     *
     * @var string @ORM\Column(name="guardian_profession", type="string",
     *      length=50, nullable=true)
     */
    private $guardianProfession;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Configuration\Entity\Gender")
     * @ORM\JoinColumn(nullable=true)
     */
    private $gender;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Configuration\Entity\MaritalStatus")
     * @ORM\JoinColumn(nullable=true)
     */
    private $maritalStatus;
    
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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param mixed $id
     *
     * @return Student
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }
    
    /**
     * @param mixed $lastname
     *
     * @return Student
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }
    
    /**
     * @param mixed $firstname
     *
     * @return Student
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }
    
    /**
     * @param mixed $birthDate
     *
     * @return Student
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getBirthPlace(): string
    {
        return $this->birthPlace;
    }
    
    /**
     * @param string $birthPlace
     *
     * @return Student
     */
    public function setBirthPlace(string $birthPlace): Student
    {
        $this->birthPlace = $birthPlace;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getMatricule()
    {
        return $this->matricule;
    }
    
    /**
     * @param mixed $matricule
     *
     * @return Student
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;
        
        return $this;
    }
    
    /**
     * @return \DateTime
     */
    public function getRegistrationDate(): \DateTime
    {
        return $this->registrationDate;
    }
    
    /**
     * @param \DateTime $registrationDate
     *
     * @return Student
     */
    public function setRegistrationDate(\DateTime $registrationDate): Student
    {
        $this->registrationDate = $registrationDate;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }
    
    /**
     * @param string $address
     *
     * @return Student
     */
    public function setAddress(string $address): Student
    {
        $this->address = $address;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
    
    /**
     * @param string $email
     *
     * @return Student
     */
    public function setEmail(string $email): Student
    {
        $this->email = $email;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }
    
    /**
     * @param string $phone
     *
     * @return Student
     */
    public function setPhone(string $phone): Student
    {
        $this->phone = $phone;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getFatherLastname(): string
    {
        return $this->fatherLastname;
    }
    
    /**
     * @param string $fatherLastname
     *
     * @return Student
     */
    public function setFatherLastname(string $fatherLastname): Student
    {
        $this->fatherLastname = $fatherLastname;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getFatherFirstname(): string
    {
        return $this->fatherFirstname;
    }
    
    /**
     * @param string $fatherFirstname
     *
     * @return Student
     */
    public function setFatherFirstname(string $fatherFirstname): Student
    {
        $this->fatherFirstname = $fatherFirstname;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getMotherLastname(): string
    {
        return $this->motherLastname;
    }
    
    /**
     * @param string $motherLastname
     *
     * @return Student
     */
    public function setMotherLastname(string $motherLastname): Student
    {
        $this->motherLastname = $motherLastname;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getMotherFirstname(): string
    {
        return $this->motherFirstname;
    }
    
    /**
     * @param string $motherFirstname
     *
     * @return Student
     */
    public function setMotherFirstname(string $motherFirstname): Student
    {
        $this->motherFirstname = $motherFirstname;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getFatherProfession(): string
    {
        return $this->fatherProfession;
    }
    
    /**
     * @param string $fatherProfession
     *
     * @return Student
     */
    public function setFatherProfession(string $fatherProfession): Student
    {
        $this->fatherProfession = $fatherProfession;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getMotherProfession(): string
    {
        return $this->motherProfession;
    }
    
    /**
     * @param string $motherProfession
     *
     * @return Student
     */
    public function setMotherProfession(string $motherProfession): Student
    {
        $this->motherProfession = $motherProfession;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getNbChild(): int
    {
        return $this->nbChild;
    }
    
    /**
     * @param int $nbChild
     *
     * @return Student
     */
    public function setNbChild(int $nbChild): Student
    {
        $this->nbChild = $nbChild;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getGuardianLastname(): string
    {
        return $this->guardianLastname;
    }
    
    /**
     * @param string $guardianLastname
     *
     * @return Student
     */
    public function setGuardianLastname(string $guardianLastname): Student
    {
        $this->guardianLastname = $guardianLastname;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getGuardianFirstname(): string
    {
        return $this->guardianFirstname;
    }
    
    /**
     * @param string $guardianFirstname
     *
     * @return Student
     */
    public function setGuardianFirstname(string $guardianFirstname): Student
    {
        $this->guardianFirstname = $guardianFirstname;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getGuardianAddress(): string
    {
        return $this->guardianAddress;
    }
    
    /**
     * @param string $guardianAddress
     *
     * @return Student
     */
    public function setGuardianAddress(string $guardianAddress): Student
    {
        $this->guardianAddress = $guardianAddress;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getGuardianPhone1(): string
    {
        return $this->guardianPhone1;
    }
    
    /**
     * @param string $guardianPhone1
     *
     * @return Student
     */
    public function setGuardianPhone1(string $guardianPhone1): Student
    {
        $this->guardianPhone1 = $guardianPhone1;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getGuardianPhone2(): string
    {
        return $this->guardianPhone2;
    }
    
    /**
     * @param string $guardianPhone2
     *
     * @return Student
     */
    public function setGuardianPhone2(string $guardianPhone2): Student
    {
        $this->guardianPhone2 = $guardianPhone2;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getGuardianProfession(): string
    {
        return $this->guardianProfession;
    }
    
    /**
     * @param string $guardianProfession
     *
     * @return Student
     */
    public function setGuardianProfession(string $guardianProfession): Student
    {
        $this->guardianProfession = $guardianProfession;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }
    
    /**
     * @param mixed $gender
     *
     * @return Student
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getMaritalStatus()
    {
        return $this->maritalStatus;
    }
    
    /**
     * @param mixed $maritalStatus
     *
     * @return Student
     */
    public function setMaritalStatus($maritalStatus)
    {
        $this->maritalStatus = $maritalStatus;
        
        return $this;
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
     *
     * @return Student
     */
    public function setCreated(\DateTime $created): Student
    {
        $this->created = $created;
        
        return $this;
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
     *
     * @return Student
     */
    public function setUpdated(\DateTime $updated): Student
    {
        $this->updated = $updated;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->firstname . ' ' . $this->lastname . ' - (' . $this->matricule . ')';
    }
}