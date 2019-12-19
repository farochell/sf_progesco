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
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Level
 *
 * @package App\Pedagogy\Entity
 *
 * @ORM\Table(name="level")
 * @ORM\Entity(repositoryClass="App\Pedagogy\Repository\LevelRepository")
 * @UniqueEntity("label",message="Ce nom est déjà utilisé pour un autre niveau")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Level
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
     * @var integer
     *
     * @ORM\Column(name="ordering", type="integer")
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $order;
    
    /**
     * @var string
     *
     * @ORM\Column(name="step", type="string", length=10)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $step;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Pedagogy\Entity\Group", mappedBy="level")
     */
    private $groups;
    
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
     * Level constructor.
     */
    public function __construct() {
        $this->label = "";
        $this->order = 1;
        $this->step = "BAC + 1";
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->label;
    }
    
    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }
    
    /**
     * @param int $order
     */
    public function setOrder(int $order): void
    {
        $this->order = $order;
    }
    
    /**
     * @return string
     */
    public function getStep(): string
    {
        return $this->step;
    }
    
    /**
     * @param string $step
     */
    public function setStep(string $step): void
    {
        $this->step = $step;
    }
    
    /**
     * @return mixed
     */
    public function getGroups()
    {
        return $this->groups;
    }
    
    /**
     * @param mixed $groups
     */
    public function setGroups($groups): void
    {
        $this->groups = $groups;
    }
    
}