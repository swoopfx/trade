<?php
namespace Training\Entity;

use Doctrine\ORM\Mapping as ORM;
use CsnUser\Entity\User;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_training", uniqueConstraints={@ORM\UniqueConstraint(name="users_training", columns={"user_id", "training_id"})})
 *
 * @author otaba
 *        
 */
class UserTraining
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="CsnUser\Entity\User", inversedBy="training")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Training", inversedBy="subscriber")
     * @ORM\JoinColumn(name="training_id", referencedColumnName="id")
     *
     * @var Training
     */
    private $training;

    /**
     * @ORM\ManyToOne(targetEntity="TrainingStatus")
     *
     * @var TrainingStatus
     */
    private $status;

    /**
     * Dated the user enroled for the progr
     * @ORM\Column(name="start_date", type="datetime", nullable=true)
     * 
     * @var \DateTime
     */
    private $startDate;

    /**
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     * 
     * @var \DateTime
     */
    private $endDate;

    /**
     * @ORM\Column(name="created_on", nullable=true, type="datetime")
     *
     * @var \DateTime
     */
    private $createdOn;

    /**
     * @ORM\Column(name="updated_on", nullable=true, type="datetime")
     *
     * @var \DateTime
     */
    private $updatedOn;
    
    /**
     * @ORM\OneToMany(targetEntity="UserCourseActivity", mappedBy="userTraining")
     * @var Collection
     */
    private $courseActivity;
    
    /**
     *  @ORM\ManyToOne(targetEntity="UserTrainingSubmitStatus")
     * @var UserTrainingSubmitStatus
     */
    private $submitStatus;
    
    /**
     * @ORM\OneToMany(targetEntity="UserSubmittedTrainingAssignment", mappedBy="userTraining")
     * @var Collection
     */
    private $submittedAssignment;

    /**
     */
    public function __construct()
    {
        
       $this->courseActivity = new ArrayCollection();
       $this->submittedAssignment = new ArrayCollection();
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
     * @return the $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     *
     * @return the $training
     */
    public function getTraining()
    {
        return $this->training;
    }

    /**
     *
     * @return the $status
     */
    public function getStatus()
    {
        return $this->status;
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
     * @return the $updatedOn
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
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
     * @param \CsnUser\Entity\User $user            
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     *
     * @param \Training\Entity\Training $training            
     */
    public function setTraining($training)
    {
        $this->training = $training;
        return $this;
    }

    /**
     *
     * @param \Training\Entity\TrainingStatus $status            
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     *
     * @param DateTime $createdOn            
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        $this->updatedOn = $createdOn;
        return $this;
    }

    /**
     *
     * @param DateTime $updatedOn            
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;
        return $this;
    }
    /**
     * @return the $startDate
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return the $endDate
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param DateTime $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @param DateTime $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }
    
    public function getCourseActivity(){
        return $this->courseActivity;
    }
    
    public function addCourseActivity(UserCourseActivity $courseActivity){
        if(!$this->courseActivity->contains($courseActivity)){
            $this->courseActivity[] = $courseActivity;
            $courseActivity->setUserTraining($this);
        }
        return $this;
    }
    
    public function removeCourseActivity(UserCourseActivity $courseActivity){
        if($this->courseActivity->contains($courseActivity)){
            $this->courseActivity->removeElement($courseActivity);
            $courseActivity->setUserTraining(NULL);
        }
        return $this;
    }
    /**
     * @return the $submitStatus
     */
    public function getSubmitStatus()
    {
        return $this->submitStatus;
    }

    /**
     * @param \Training\Entity\UserTrainingSubmitStatus $submitStatus
     */
    public function setSubmitStatus($submitStatus)
    {
        $this->submitStatus = $submitStatus;
        return $this;
    }
    /**
     * @return the $submittedAssignment
     */
    public function getSubmittedAssignment()
    {
        return $this->submittedAssignment;
    }


    
    

}

