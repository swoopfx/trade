<?php
namespace Training\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Defines Activation of Training whic is a yardstick for reward points
 * @ORM\Entity
 * @ORM\Table(name="training_activation")
 * 
 * @author mac
 *        
 */
class TrainingActivation
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Training")
     * 
     * @var Training
     */
    private $training;

    /**
     * This is the maximum amount of awadee for this program ie the total maximum of people that cant be rewarded
     * @ORM\Column(name="maximum_count", type="integer", options={"unsigned"=true}, nullable=false)
     * 
     * @var integer
     */
    private $maximumCount;

    /**
     * This is the total amount of users that has been award this training reward
     * Usually this is less than or equals to the maximum count
     * But never more than 
     * @ORM\Column(name="users_awarded_count", type="integer", options={"unsigned"=true, "default"="0"}, nullable=false)
     * 
     * @var integer
     *
     */
    private $usersAwardedCount;

    /**
     * @ORM\Column(name="startdate", type="datetime", nullable=false)
     * 
     * @var \DateTime
     */
    private $startdate;

    /**
     * @ORM\Column(name="enddate", type="datetime", nullable=false)
     * 
     * @var \Datetime
     */
    private $enddate;

    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     * 
     * @var \DateTime
     */
    private $createdOn;

    /**
     * @ORM\Column(name="updated_on", type="datetime", nullable=false)
     * 
     * @var \DateTime
     */
    private $updatedOn;

    /**
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
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
     * @return the $maximumCount
     */
    public function getMaximumCount()
    {
        return $this->maximumCount;
    }

    /**
     * @return the $usersAwardedCount
     */
    public function getUsersAwardedCount()
    {
        return $this->usersAwardedCount;
    }

    /**
     * @return the $startdate
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * @return the $enddate
     */
    public function getEnddate()
    {
        return $this->enddate;
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
     * @return the $isActive
     */
    public function getIsActive()
    {
        return $this->isActive;
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

    /**
     * @param number $maximumCount
     */
    public function setMaximumCount($maximumCount)
    {
        $this->maximumCount = $maximumCount;
        return $this;
    }

    /**
     * @param number $usersAwardedCount
     */
    public function setUsersAwardedCount($usersAwardedCount)
    {
        $this->usersAwardedCount = $usersAwardedCount;
        return $this;
    }

    /**
     * @param DateTime $startdate
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;
        return $this;
    }

    /**
     * @param Datetime $enddate
     */
    public function setEnddate($enddate)
    {
        $this->enddate = $enddate;
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
     * @param \Training\Entity\unknown $updatedOn
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;
        return $this;
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

