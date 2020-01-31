<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   14/01/2020
 * @time  :   23:25
 */

namespace App\Accounting\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ExpenseLine
 *
 * @package App\Accounting\Entity
 * @ORM\Table(name="expense_line")
 * @ORM\Entity(repositoryClass="App\Accounting\Repository\ExpenseLineRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ExpenseLine
{
    const INIT    = 1;
    const VALIDED = 2;
    const REFUSED = 3;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Accounting\Entity\ExpenseType")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $expenseType;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Pedagogy\Entity\SchoolYear")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $schoolYear;
    
    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=100, nullable=true)
     *
     */
    private $reference;
    
    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $amount;
    
    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expense_date", type="datetime")
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $expenseDate;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;
    
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
    public function getExpenseType()
    {
        return $this->expenseType;
    }
    
    /**
     * @param mixed $expenseType
     */
    public function setExpenseType($expenseType): void
    {
        $this->expenseType = $expenseType;
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
     * @return \DateTime
     */
    public function getExpenseDate(): ?\DateTime
    {
        return $this->expenseDate;
    }
    
    /**
     * @param \DateTime $expenseDate
     */
    public function setExpenseDate(\DateTime $expenseDate): void
    {
        $this->expenseDate = $expenseDate;
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
     * ExpenseLine constructor.
     */
    public function __construct() {
        $this->status = self::INIT;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return 'Dépense N° ' . $this->getReference();
    }
}