<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   29/12/2019
 * @time  :   19:27
 */

namespace App\Student\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class StudentPhoto
 *
 * @package App\Student\Entity
 * @ORM\Table(name="student_photo")
 * @ORM\Entity(repositoryClass="App\Student\Repository\StudentPhotoRepository")
 *
 */
class StudentPhoto
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
     * @ORM\ManyToOne(targetEntity="App\Student\Entity\Student", inversedBy="studentPhotos")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $student;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Configuration\Entity\TypeDocument")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Ce champ doit être renseigné")
     */
    private $typeDocument;
    
    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=100, nullable=true)
     */
    private $image;
    
    /**
     * @Vich\UploadableField(mapping="student_photo", fileNameProperty="image")
     *
     * @var File
     */
    private $imageFile;
    
    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=30, nullable=true)
     */
    private $label;
    
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
    public function getStudent()
    {
        return $this->student;
    }
    
    /**
     * @param mixed $student
     */
    public function setStudent($student): void
    {
        $this->student = $student;
    }
    
    /**
     * @return mixed
     */
    public function getTypeDocument()
    {
        return $this->typeDocument;
    }
    
    /**
     * @param mixed $typeDocument
     */
    public function setTypeDocument($typeDocument): void
    {
        $this->typeDocument = $typeDocument;
    }
    
    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }
    
    /**
     * @param string $image
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }
    
    /**
     * @return File
     */
    public function getImageFile(): File
    {
        return $this->imageFile;
    }
    
    /**
     * @param File $imageFile
     */
    public function setImageFile(File $imageFile): void
    {
        $this->imageFile = $imageFile;
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
}