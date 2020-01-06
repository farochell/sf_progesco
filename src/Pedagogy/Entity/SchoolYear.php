<?php
/**
 * sf_progesco
 *
 * emile.camara
 * 20/11/2019
 */

namespace App\Pedagogy\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class SchoolYear
 *
 * @package App\Pedagogy\Entity
 * @ORM\Table(name="school_year")
 * @ORM\Entity(repositoryClass="App\Pedagogy\Repository\SchoolYearRepository")
 * @UniqueEntity("label",message="Ce nom est déjà utilisé pour une autre année scolaire")
 * @ORM\HasLifecycleCallbacks()
 */
class SchoolYear
{
    const ACTIVE_YEAR = 1;
    const NO_ACTIVE_YEAR = 0;
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
     * @ORM\Column(name="label", type="string", length=9, unique=true)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $label;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="date")
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $startDate;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date")
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $endDate;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    
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
     * @return \DateTime
     */
    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }
    
    /**
     * @param \DateTime $startDate
     */
    public function setStartDate(\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }
    
    /**
     * @return \DateTime
     */
    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }
    
    /**
     * @param \DateTime $endDate
     */
    public function setEndDate(\DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }
    
    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }
    
    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
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
    public function __toString()
    {
        return $this->label;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function setIsActiveValue()
    {
        $this->isActive = self::ACTIVE_YEAR;
    }
    
    /**
     * SchoolYear constructor.
     */
    public function __construct() {
        $this->label = "";
    }
}