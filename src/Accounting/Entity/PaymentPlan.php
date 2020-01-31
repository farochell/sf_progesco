<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/01/2020
 * @time  :   14:09
 */

namespace App\Accounting\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class PaymentPlan
 *
 * @package App\Accounting\Entity
 * @ORM\Table(name="payment_plan")
 * @ORM\Entity(repositoryClass="App\Accounting\Repository\PaymentPlanRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @UniqueEntity(
 *     fields={"label", "payment"},
 *     errorPath="label",
 *     message="Ce libellé est déjà utilisé"
 * )
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class PaymentPlan
{
    const PAYMENT_INIT              = 1;
    const PAYMENT_CASH              = 2;
    const PAYMENT_CHQ_W             = 30;
    const PAYMENT_CHQ_V             = 31;
    const PAYMENT_CHQ_C             = 33;
    const PAYMENT_BANK_TFT_W        = 40;
    const PAYMENT_BANK_TFT_V        = 41;
    const PAYMENT_BANK_TFT_C        = 42;
    const PAYMENT_CNL               = -1;
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
     * @ORM\Column(name="label", type="string", length=50)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $label;
    
    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=50, nullable=true)
     */
    private $reference;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Accounting\Entity\Payment", inversedBy="paymentPlans")
     * @ORM\JoinColumn(nullable=false)
     */
    private $payment;
    
    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float")
     */
    private $amount;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_collection", type="date", nullable=true)
     */
    private $dateOfCollection;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registration_date", type="date")
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $registrationDate;
    
    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;
    
    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;
    
    /**
     * @ORM\OneToOne(targetEntity="App\Accounting\Entity\Cheque", mappedBy="paymentPlan", cascade={"persist", "remove"})
     */
    private $cheque;
    
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
    public function getPayment()
    {
        return $this->payment;
    }
    
    /**
     * @param mixed $payment
     */
    public function setPayment($payment): void
    {
        $this->payment = $payment;
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
     * @return \DateTime
     */
    public function getDateOfCollection(): \DateTime
    {
        return $this->dateOfCollection;
    }
    
    /**
     * @param \DateTime $dateOfCollection
     */
    public function setDateOfCollection(\DateTime $dateOfCollection): void
    {
        $this->dateOfCollection = $dateOfCollection;
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
     */
    public function setRegistrationDate(\DateTime $registrationDate): void
    {
        $this->registrationDate = $registrationDate;
    }
    
    /**
     * @return string
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }
    
    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
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
     * @return string
     */
    public function __toString()
    {
        return $this->label . ' (Paiement N°' . $this->getPayment()->getReference(). ')';
    }
    
    /**
     * @return mixed
     */
    public function getCheque()
    {
        return $this->cheque;
    }
    
    /**
     * @param mixed $cheque
     */
    public function setCheque($cheque): void
    {
        $this->cheque = $cheque;
    }
    
    /**
     * @return string
     */
    public function getReference(): ?string
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
     * PaymentPlan constructor.
     * @throws \Exception
     */
    public function __construct() {
        $this->label            = "";
        $this->status           = self::PAYMENT_INIT;
        $this->registrationDate = new \DateTime('now');
        $this->dateOfCollection = new \DateTime('now');
    }
}