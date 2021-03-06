<?php
/**
 * sf_progesco
 *
 * emile.camara
 * 19/11/2019
 */

namespace App\Pedagogy\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Grade
 *
 * @package App\Pedagogy\Entity
 *
 * @ORM\Table(name="grade")
 * @ORM\Entity(repositoryClass="App\Pedagogy\Repository\GradeRepository")
 * @UniqueEntity(
 *     fields={"label", "study", "level"},
 *     errorPath="label",
 *     message="Une classe déjà créée porte le même nom"
 * )
 */
class Grade {
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
     * @ORM\Column(name="label", type="string", length=15)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $label;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Pedagogy\Entity\Study", inversedBy="grades")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $study;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Pedagogy\Entity\Level", inversedBy="grades")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $level;
    
    /**
     * @var \DateTime $created
     *
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;
    
    /**
     * @var \DateTime $updated
     *
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
     * @return mixed
     */
    public function getStudy() {
        return $this->study;
    }
    
    /**
     * @param mixed $study
     */
    public function setStudy($study): void {
        $this->study = $study;
    }
    
    /**
     * @return mixed
     */
    public function getLevel() {
        return $this->level;
    }
    
    /**
     * @param mixed $level
     */
    public function setLevel($level): void {
        $this->level = $level;
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
     * Grade constructor.
     */
    public function __construct() {
        $this->label = "";
    }
    
    public function __toString() {
        return $this->label.' ( '.$this->study.' )';
    }
    
    
}