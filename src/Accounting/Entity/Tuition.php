<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   24/12/2019
 * @time  :   16:04
 */

namespace App\Accounting\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Tuition
 *
 * @package App\Accounting\Entity
 * @ORM\Table(name="tuition")
 * @ORM\Entity(repositoryClass="App\Accounting\Repository\TuitionRepository")
 * @UniqueEntity(
 *     fields={"schoolYear", "level"},
 *     errorPath="level",
 *     message="Le tarif pour ce niveau a déjà été renseigné"
 * )
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Tuition
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
     * @var float
     *
     * @ORM\Column(name="fees", type="float")
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $fees;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Pedagogy\Entity\Level")
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Pedagogy\Entity\SchoolYear")
     * @ORM\JoinColumn(nullable=false)
     */
    private $schoolYear;
    
    /**
     * @ORM\ManyToMany(targetEntity="App\Pedagogy\Entity\Study", cascade={"persist"})
     */
    private $studies;
    
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
     * @var \DateTime $updated
     *
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;
    
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
     * @return float
     */
    public function getFees(): float
    {
        return $this->fees;
    }
    
    /**
     * @param float $fees
     */
    public function setFees(float $fees): void
    {
        $this->fees = $fees;
    }
    
    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }
    
    /**
     * @param mixed $level
     */
    public function setLevel($level): void
    {
        $this->level = $level;
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
     * @return mixed
     */
    public function getStudies()
    {
        return $this->studies;
    }
    
    /**
     * @param mixed $studies
     */
    public function setStudies($studies): void
    {
        $this->studies = $studies;
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
}