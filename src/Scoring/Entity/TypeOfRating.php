<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   03/02/2020
 * @time  :   11:05
 */

namespace App\Scoring\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class TypeOfRating
 *
 * @package App\Scoring\Entity
 * @ORM\Table(name="type_of_rating")
 * @ORM\Entity(repositoryClass="App\Scoring\Repository\TypeOfRatingRepository")
 * @UniqueEntity(
 *     fields={"label"},
 *     errorPath="label",
 *     message="Cet libellé est déjà utilisé."
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class TypeOfRating {
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
     * @return string
     */
    public function __toString() {
        return $this->label;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function setCreatedValue()
    {
        $this->created = new \DateTime();
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
        $this->updated = new \DateTime();
    }
}