<?php
namespace Training\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Training\Entity\Repository\CourseRepository")
 * @ORM\Table(name="course")
 *
 * @author otaba
 *        
 */
class Course
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="course_title", type="string", nullable=true)
     *
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(name="course_code", type="string", nullable=true)
     *
     * @var string
     */
    private $courseCode;

    /**
     * @ORM\Column(name="course_uid", type="string", nullable=true)
     *
     * @var string
     */
    private $courseUid;

    /**
     * @ORM\Column(name="course_video", type="string", nullable=true)
     *
     * @var string
     */
    private $video;

    /**
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     *
     * @var boolean
     */
    private $isActive;

    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $createdOn;

    /**
     * @ORM\Column(name="updated_on", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updated;

    /**
     * @ORM\ManyToOne(targetEntity="Programmes", inversedBy="course")
     * 
     * @var Programmes
     */
    private $progammes;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    /**
     *
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return the $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     *
     * @return the $courseCode
     */
    public function getCourseCode()
    {
        return $this->courseCode;
    }

    /**
     *
     * @return the $courseUid
     */
    public function getCourseUid()
    {
        return $this->courseUid;
    }

    /**
     *
     * @return the $video
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     *
     * @return the $isActive
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     *
     * @return the $createdOn
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     *
     * @return the $updated
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     *
     * @param number $id            
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @param string $title            
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     *
     * @param string $courseCode            
     */
    public function setCourseCode($courseCode)
    {
        $this->courseCode = $courseCode;
        return $this;
    }

    /**
     *
     * @param string $courseUid            
     */
    public function setCourseUid($courseUid)
    {
        $this->courseUid = $courseUid;
        return $this;
    }

    /**
     *
     * @param \Training\Entity\unknown $video            
     */
    public function setVideo($video)
    {
        $this->video = $video;
        return $this;
    }

    /**
     *
     * @param boolean $isActive            
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     *
     * @param DateTime $createdOn            
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        $this->updated = $createdOn;
        return $this;
    }

    /**
     *
     * @param DateTime $updated            
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }
    /**
     * @return the $progammes
     */
    public function getProgammes()
    {
        return $this->progammes;
    }

    /**
     * @param \Training\Entity\Programmes $progammes
     */
    public function setProgammes($progammes)
    {
        $this->progammes = $progammes;
        return $this;
    }

}

