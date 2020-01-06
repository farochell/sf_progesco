<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   02/01/2020
 * @time  :   17:32
 */

namespace App\Accounting\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Payment
 *
 * @package App\Accounting\Entity
 * @ORM\Table(name="scholarship_payment")
 * @ORM\Entity(repositoryClass="App\Accounting\Repository\ScholarshipPaymentRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class ScholarshipPayment
{
    const NO_PAID         = 1;
    const PAID            = 2;
    const CANCELED        = 3;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\OneToOne(targetEntity="App\Schooling\Entity\Registration")
     * @ORM\JoinColumn(nullable=false)
     */
    private $registration;
    
    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=20, nullable=true)
     */
    private $reference;
    
    /**
     * @var float
     *
     * @ORM\Column(name="tuition", type="float")
     * @Assert\NotBlank(message="Les frais de scolarités n'ont pas été définies pour l'année scolaire en cours. Veuillez contacter l'administrateur.")
     *
     */
    private $tuition;
    
    /**
     * @var float
     *
     * @ORM\Column(name="balance", type="float")
     */
    private $balance;
    
    /**
     * @var int
     * @ORM\Column(name="status", type="integer")
     */
    private $status;
    
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
     * @return int
     */
    public function getId(): ?int
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
    public function getRegistration()
    {
        return $this->registration;
    }
    
    /**
     * @param mixed $registration
     */
    public function setRegistration($registration): void
    {
        $this->registration = $registration;
    }
    
    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }
    
    /**
     * @param string $reference
     */
    public function setReference(string $reference): void
    {
        $this->reference = $reference;
    }
    
    /**
     * @return float
     */
    public function getTuition(): ?float
    {
        return $this->tuition;
    }
    
    /**
     * @param float $tuition
     */
    public function setTuition(float $tuition): void
    {
        $this->tuition = $tuition;
    }
    
    /**
     * @return float
     */
    public function getBalance(): float
    {
        return $this->balance;
    }
    
    /**
     * @param float $balance
     */
    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
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
     * ScholarshipPayment constructor.
     */
    public function __construct() {
        $this->status = self::NO_PAID;
    }
    
    /**
     * @return string
     */
    public function __toString(){
        return 'Payement N°'. $this->reference;
    }
}