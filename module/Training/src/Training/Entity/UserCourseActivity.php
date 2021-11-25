<?php
namespace Training\Entity;

use Doctrine\ORM\Mapping as ORM;
use CsnUser\Entity\User;

/**
 *
 * @author Ajayi Oluwaseun Ezekiel (ezekiel_a@yahoo.com)
 * @copyright 20 Mar 2021 I-Manager Solutions, Nigeria
 *            Tanim Retailer
 *            This class is used to monitor progress activity of the course in the progress
 *            One a course is clicked, this activity is hydrated
 *            @ORM\Entity
 *            @ORM\Table(name="user_course_activity")
 *           
 */
class UserCourseActivity
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="CsnUser\Entity\User")
     * 
     * @var User
     */
    private $user;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Course")
     * 
     * @var Course
     */
    private $course;

    /**
     * @ORM\ManyToOne(targetEntity="UserTraining", inversedBy="courseActivity")
     * 
     * @var UserTraining
     */
    private $userTraining;

    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true, options={"default": "CURRENT_TIMESTAMP"})
     * 
     * @var \DateTime
     */
    private $createdOn;

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
     * @return the $course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     *
     * @return the $userTraining
     */
    public function getUserTraining()
    {
        return $this->userTraining;
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
     * @param \Training\Entity\Course $course            
     */
    public function setCourse($course)
    {
        $this->course = $course;
        return $this;
    }

    /**
     *
     * @param \Training\Entity\UserTraining $userTraining            
     */
    public function setUserTraining($userTraining)
    {
        $this->userTraining = $userTraining;
        return $this;
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
     * @param DateTime $createdOn            
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }
}

