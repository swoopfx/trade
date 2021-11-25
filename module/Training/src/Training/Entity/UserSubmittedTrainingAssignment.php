<?php
namespace Training\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use CsnUser\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_submitted_training_assignment")
 * @author mac
 *        
 */
class UserSubmittedTrainingAssignment
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="TrainingAssigmentMilestone")
     * @var TrainingAssigmentMilestone
     */
    private $milestone;
    
    /**
     * @ORM\Column(name="answerss", type="text", nullable=true)
     * @var string
     */
    private $answerss; 
    
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
    
//     /**
//      * @ORM\ManyToOne(targetEntity="CsnUser\Entity\User")
//      * @var User
//      */
//     private $user;

    /**
     * @ORM\ManyToOne(targetEntity="UserTraining", inversedBy="submittedAssignment")
     * @var UserTraining
     */
    private $userTraining;
    
    /**
     * @ORM\OneToMany(targetEntity="Training\Entity\UserSubmittedAssignmentResources", mappedBy="submmitedMilestone")
     * @var Collection
     */
    private $resourcess;
    
    /**
     */
    public function __construct()
    {
        
       $this->resourcess = new ArrayCollection();
    }
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $milestone
     */
    public function getMilestone()
    {
        return $this->milestone;
    }

    /**
     * @return the $answerss
     */
    public function getAnswerss()
    {
        return $this->answerss;
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

//     /**
//      * @return the $user
//      */
//     public function getUser()
//     {
//         return $this->user;
//     }

    /**
     * @return the $resourcess
     */
    public function getResourcess()
    {
        return $this->resourcess;
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
     * @param \Training\Entity\TrainingAssigmentMilestone $milestone
     */
    public function setMilestone($milestone)
    {
        $this->milestone = $milestone;
        return $this;
    }

    /**
     * @param string $answerss
     */
    public function setAnswerss($answerss)
    {
        $this->answerss = $answerss;
        return $this;
    }

    /**
     * @param DateTime $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
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

//     /**
//      * @param \CsnUser\Entity\User $user
//      */
//     public function setUser($user)
//     {
//         $this->user = $user;
//         return $this;
//     }
    
    
    public function addResourcess(UserSubmittedAssignmentResources $resourcess){
        if(!$this->resourcess->contains($resourcess)){
            $this->resourcess->add($resourcess);
            $resourcess->setSubmmitedMilestone($this);
        }
        return $this;
    }
    
    
    public function removeResourcess(UserSubmittedAssignmentResources $resourcess){
        if($this->resourcess->contains($resourcess)){
            $this->resourcess->removeElement($resourcess);
            $resourcess->setSubmmitedMilestone(NULL);
        }
        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $resourcess
     */
    public function setResourcess($resourcess)
    {
        $this->resourcess = $resourcess;
        return $this;
    }
    /**
     * @return the $userTraining
     */
    public function getUserTraining()
    {
        return $this->userTraining;
    }

    /**
     * @param \Training\Entity\UserTraining $userTraining
     */
    public function setUserTraining($userTraining)
    {
        $this->userTraining = $userTraining;
        return $this;
    }


}

