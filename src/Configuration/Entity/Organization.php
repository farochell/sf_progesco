<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   14/01/2020
 * @time  :   11:12
 */

namespace App\Configuration\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Organization
 *
 * @package App\Configuration\Entity
 * @ORM\Table(name="organization")
 * @ORM\Entity(repositoryClass="App\Configuration\Repository\OrganizationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Organization
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="academy", type="string", length=50, nullable=true)
     */
    private $academy;
    
    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text")
     */
    private $address;
    
    /**
     * @var string
     *
     * @ORM\Column(name="postal_code", type="string", length=10, nullable=true)
     */
    private $postalCode;
    
    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=50)
     */
    private $city;
    
    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=20)
     */
    private $country;
    
    /**
     * @var string
     *
     * @ORM\Column(name="phone_1", type="string", length=10)
     */
    private $phone1;
    
    /**
     * @var string
     *
     * @ORM\Column(name="phone_2", type="string", length=10, nullable=true)
     */
    private $phone2;
    
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=true)
     */
    private $email;
    
    /**
     * @var string
     *
     * @ORM\Column(name="director_name", type="string", length=100, nullable=true)
     */
    private $directorName;
    
    /**
     * @var string
     *
     * @ORM\Column(name="web_site", type="string", length=100, nullable=true)
     */
    private $webSite;
    
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
    public function getName(): ?string
    {
        return $this->name;
    }
    
    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    
    /**
     * @return string
     */
    public function getAcademy(): ?string
    {
        return $this->academy;
    }
    
    /**
     * @param string $academy
     */
    public function setAcademy(string $academy): void
    {
        $this->academy = $academy;
    }
    
    /**
     * @return string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }
    
    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }
    
    /**
     * @return string
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }
    
    /**
     * @param string $postalCode
     */
    public function setPostalCode(string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }
    
    /**
     * @return string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }
    
    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }
    
    /**
     * @return string
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }
    
    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }
    
    /**
     * @return string
     */
    public function getPhone1(): ?string
    {
        return $this->phone1;
    }
    
    /**
     * @param string $phone1
     */
    public function setPhone1(string $phone1): void
    {
        $this->phone1 = $phone1;
    }
    
    /**
     * @return string
     */
    public function getPhone2(): ?string
    {
        return $this->phone2;
    }
    
    /**
     * @param string $phone2
     */
    public function setPhone2(string $phone2): void
    {
        $this->phone2 = $phone2;
    }
    
    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }
    
    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    
    /**
     * @return string
     */
    public function getDirectorName(): ?string
    {
        return $this->directorName;
    }
    
    /**
     * @param string $directorName
     */
    public function setDirectorName(string $directorName): void
    {
        $this->directorName = $directorName;
    }
    
    /**
     * @return string
     */
    public function getWebSite(): ?string
    {
        return $this->webSite;
    }
    
    /**
     * @param string $webSite
     */
    public function setWebSite(string $webSite): void
    {
        $this->webSite = $webSite;
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