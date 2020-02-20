<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   21/11/2019
 * @time  :   12:14
 */

namespace App\Pedagogy\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CoursePeriod
 *
 * @package App\Pedagogy\Entity
 * @ORM\Table(name="course_period")
 * @ORM\Entity(repositoryClass="App\Pedagogy\Repository\CoursePeriodRepository")
 * @UniqueEntity("label",message="Ce nom est déjà utilisé")
 * @ORM\HasLifecycleCallbacks()
 */
class CoursePeriod {
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
     * @ORM\Column(name="label", type="string", length=20)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $label;
    
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
    public function getId(): int {
        return $this->id;
    }
    
    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }
    
    /**
     * @return string
     */
    public function getLabel(): string {
        return $this->label;
    }
    
    /**
     * @param string $label
     */
    public function setLabel(string $label): void {
        $this->label = $label;
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
    
    /**
     * @return \DateTime
     */
    public function getDeletedAt(): \DateTime {
        return $this->deletedAt;
    }
    
    /**
     * @param \DateTime $deletedAt
     */
    public function setDeletedAt(\DateTime $deletedAt): void {
        $this->deletedAt = $deletedAt;
    }
    
    /**
     * CoursePeriod constructor.
     */
    public function __construct() {
        $this->label = "";
    }
    
    /**
     * @return string
     */
    public function __toString() {
        return $this->label;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        $this->created = new \DateTime();
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue() {
        $this->updated = new \DateTime();
    }
}