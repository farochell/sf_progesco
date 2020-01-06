<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/01/2020
 * @time  :   17:54
 */

namespace App\Accounting\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Cheque
 *
 * @package App\Accounting\Entity
 * @ORM\Table(name="cheque")
 * @ORM\Entity(repositoryClass="App\Accounting\Repository\ChequeRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Cheque
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
     * @ORM\OneToOne(targetEntity="App\Accounting\Entity\PaymentPlan", inversedBy="cheque")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $paymentPlan;
    
    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;
    
    /**
     * @var string
     *
     * @ORM\Column(name="holder", type="string", length=20, nullable=true)
     */
    private $holder;
    
    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=20, nullable=true)
     */
    private $number;
    
    /**
     * @var string
     *
     * @ORM\Column(name="bank", type="string", length=30, nullable=true)
     */
    private $bank;
    
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
    public function getPaymentPlan()
    {
        return $this->paymentPlan;
    }
    
    /**
     * @param mixed $paymentPlan
     */
    public function setPaymentPlan($paymentPlan): void
    {
        $this->paymentPlan = $paymentPlan;
    }
    
    /**
     * @return float
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }
    
    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }
    
    /**
     * @return string
     */
    public function getHolder(): ?string
    {
        return $this->holder;
    }
    
    /**
     * @param string $holder
     */
    public function setHolder(string $holder): void
    {
        $this->holder = $holder;
    }
    
    /**
     * @return string
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }
    
    /**
     * @param string $number
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }
    
    /**
     * @return string
     */
    public function getBank(): ?string
    {
        return $this->bank;
    }
    
    /**
     * @param string $bank
     */
    public function setBank(string $bank): void
    {
        $this->bank = $bank;
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
     * @return string
     */
    public function __toString()
    {
        return $this->holder;
    }
    
}