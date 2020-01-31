<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   23/01/2020
 * @time  :   14:12
 */

namespace App\Accounting\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ExpenseLineDocument
 *
 * @package App\Accounting\Entity
 * @ORM\Table(name="expense_line_document")
 * @ORM\Entity(repositoryClass="App\Accounting\Repository\ExpenseLineDocumentRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ExpenseLineDocument {
    /**
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Accounting\Entity\ExpenseLine")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $expenseLine;
    
    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=100)
     */
    private $label;
    
    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;
    
    /**
     *
     * @ORM\Column(type="string", type="string", nullable=true)
     */
    private $thumbnailName;
    
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
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;
    
    /**
     * @var \DateTime $created
     *
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated;
    
    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * @param mixed $id
     */
    public function setId($id): void {
        $this->id = $id;
    }
    
    /**
     * @return mixed
     */
    public function getExpenseLine() {
        return $this->expenseLine;
    }
    
    /**
     * @param mixed $expenseLine
     */
    public function setExpenseLine($expenseLine): void {
        $this->expenseLine = $expenseLine;
    }
    
    /**
     * @return string
     */
    public function getLabel(): ?string {
        return $this->label;
    }
    
    /**
     * @param string $label
     */
    public function setLabel(string $label): void {
        $this->label = $label;
    }
    
    /**
     * @return string
     */
    public function getComment():  ?string {
        return $this->comment;
    }
    
    /**
     * @param string $comment
     */
    public function setComment(string $comment): void {
        $this->comment = $comment;
    }
    
    /**
     * @return mixed
     */
    public function getThumbnailName() {
        return $this->thumbnailName;
    }
    
    /**
     * @param mixed $thumbnailName
     */
    public function setThumbnailName($thumbnailName): void {
        $this->thumbnailName = $thumbnailName;
    }
    
    /**
     * @return mixed
     */
    public function getUserCreation() {
        return $this->userCreation;
    }
    
    /**
     * @param mixed $userCreation
     */
    public function setUserCreation($userCreation): void {
        $this->userCreation = $userCreation;
    }
    
    /**
     * @return mixed
     */
    public function getUserModification() {
        return $this->userModification;
    }
    
    /**
     * @param mixed $userModification
     */
    public function setUserModification($userModification): void {
        $this->userModification = $userModification;
    }
    
    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime {
        return $this->created;
    }
    
    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created): void {
        $this->created = $created;
    }
    
    /**
     * @return \DateTime
     */
    public function getUpdated(): \DateTime {
        return $this->updated;
    }
    
    /**
     * @param \DateTime $updated
     */
    public function setUpdated(\DateTime $updated): void {
        $this->updated = $updated;
    }
    
}