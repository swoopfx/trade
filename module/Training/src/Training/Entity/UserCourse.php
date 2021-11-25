<?php
namespace Training\Entity;

use Doctrine\ORM\Mapping as ORM;
use CsnUser\Entity\User;
//, uniqueConstraints={@ORM\UniqueConstraint(name="users_course", columns={"user_id", "course_id"})}
/**
 * @ORM\Entity
 * @ORM\Table(name="user_course")
 * 
 * @author otaba
 *        
 */
class UserCourse
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserTraining")
     * @var UserTraining
     */
    private $userTraining;
    
    /**
     * This is used to monitor the activity of click on each course 
     * @ORM\Column(name="activity_count", type="string", nullable=true)
     * @var string
     */
    private $activityCount;

    /**
     * @ORM\Column(name="end_date", type="datetime")
     * 
     * @var Dateitme
     */
    private $endDate;

    /**
     * @ORM\Column(name="created_on", type="datetime")
     * 
     * @var \DateTime
     */
    private $createdOn;

    /**
     * @ORM\Column(name="updated_on", type="datetime")
     * 
     * @var \DateTime
     */
    private $updatedOn;

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
     * @return the $userTraining
     */
    public function getUserTraining()
    {
        return $this->userTraining;
    }

    /**
     * @return the $activityCount
     */
    public function getActivityCount()
    {
        return $this->activityCount;
    }

    /**
     * @return the $endDate
     */
    public function getEndDate()
    {
        return $this->endDate;
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
     * @param \Training\Entity\UserTraining $userTraining
     */
    public function setUserTraining($userTraining)
    {
        $this->userTraining = $userTraining;
        return $this;
    }

    /**
     * @param string $activityCount
     */
    public function setActivityCount($activityCount)
    {
        $this->activityCount = $activityCount;
        return $this;
    }

    /**
     * @param \Training\Entity\Dateitme $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
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

}

