<?php
namespace Training\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
/**
 * @ORM\Entity(repositoryClass="Training\Entity\Repository\ProgrammesRepository")
 * @ORM\Table(name="programmes")
 * @author otaba
 *        
 */
class Programmes
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\Column(name="programmes_uid", type="string", nullable=true)
     * @var string
     */
    private $programmesUid;
    
    /**
     * @ORM\ManyToOne(targetEntity="Training", inversedBy="programmes")
     * @var Training
     */
    private $training;
     
    /**
     * @ORM\OneToMany(targetEntity="Training\Entity\Course", mappedBy="progammes", cascade={"remove"})
     * @var Collection
     */
    private $course;
    
    /**
     * @ORM\Column(name="programe_title", type="string", nullable=true)
     * @var string
     */
    private $title;
    
    /**
     * @ORM\Column(name="program_description", type="text", nullable=true)
     * @var string
     */
    private $description;
    
    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     * @var \DateTime
     */
    private $createdOn;
    
    /**
     * @ORM\Column(name="updated_on", type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedOn;

    /**
     * @ORM\Column(name="isActive", type="boolean", nullable=true, options={"default":"1"})
     * @var boolean
     */
    private $isActive;
    
    
   
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $training
     */
    public function getTraining()
    {
        return $this->training;
    }

    /**
     * @return the $course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @return the $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return the $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return the $createdOn
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @return the $updatedOn
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param \Training\Entity\Training $training
     */
    public function setTraining($training)
    {
        $this->training = $training;
        return $this;
    }

//     /**
//      * @param \Doctrine\Common\Collections\Collection $course
//      */
//     public function setCourse($course)
//     {
//         $this->course = $course;
//         return $this;
//     }

    /**
     * 
     * @param Course $course
     */
    public function addCourse($course){
        if(!$this->course->contains($course)){
            $this->course->add($course);
            $course->setProgammes($this);
        }
        return $this;
    }
    
    /**
     *
     * @param Course $course
     */
    public function removeCourse($course){
        if($this->course->contains($course)){
            $this->course->removeElement($course);
            $course->setProgammes(NULL);
        }
        return $this;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param DateTime $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        $this->updatedOn = $createdOn;
        return $this;
    }

    /**
     * @param DateTime $updatedOn
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;
        return $this;
    }
    /**
     * @return the $programmesUid
     */
    public function getProgrammesUid()
    {
        return $this->programmesUid;
    }

    /**
     * @param string $programmesUid
     */
    public function setProgrammesUid($programmesUid)
    {
        $this->programmesUid = $programmesUid;
        return $this;
    }
    /**
     * @return the $isActive
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }



}

