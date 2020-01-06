<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   21/11/2019
 * @time  :   11:52
 */

namespace App\Pedagogy\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Group
 *
 * @package App\Pedagogy\Entity
 *
 * @ORM\Table(name="cgroup")
 * @ORM\Entity(repositoryClass="App\Pedagogy\Repository\GroupRepository")
 * @UniqueEntity(
 *     fields={"label", "level", "schoolyear"},
 *     errorPath="label",
 *     message="Un groupe portant ce nom a déjà été attribué pour ce niveau et cette année scolaire"
 * )
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Group
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
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=20)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $label;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Pedagogy\Entity\SchoolYear")
     * @ORM\JoinColumn(nullable=false)
     */
    private $schoolyear;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Pedagogy\Entity\Level", inversedBy="groups")
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="effective", type="integer", unique=false)
     */
    private $effective;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Pedagogy\Entity\CoursePeriod")
     * @ORM\JoinColumn(nullable=true)
     */
    private $coursePeriod;
    
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
    public function getSchoolyear()
    {
        return $this->schoolyear;
    }
    
    /**
     * @param mixed $schoolyear
     */
    public function setSchoolyear($schoolyear): void
    {
        $this->schoolyear = $schoolyear;
    }
    
    /**
     * @return int
     */
    public function getEffective(): int
    {
        return $this->effective;
    }
    
    /**
     * @param int $effective
     */
    public function setEffective(int $effective): void
    {
        $this->effective = $effective;
    }
    
    /**
     * @return mixed
     */
    public function getCoursePeriod()
    {
        return $this->coursePeriod;
    }
    
    /**
     * @param mixed $coursePeriod
     */
    public function setCoursePeriod($coursePeriod): void
    {
        $this->coursePeriod = $coursePeriod;
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
     * @return string
     */
    public function __toString(){
        return $this->label . ' - ' . $this->getLevel();
    }
    
    /**
     * Group constructor.
     */
    public function __construct() {
        $this->label     = "";
        $this->effective = 0;
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
    
}