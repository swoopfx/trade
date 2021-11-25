<?php
namespace Training\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_training_activity")
 * @author mac
 *        
 */
class UserTrainingActivity
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     *  @ORM\ManyToOne(targetEntity="UserTraining")
     * @var UserTraining
     */
    private $userraining;
    
    /**
     * @ORM\Column(name="activity", type="text", nullable=true)
     * @var string
     */
    private $activity;
    
    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     * @var \DateTime
     */
    private $createdOn;
    
    
    
    
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
     * @return the $userraining
     */
    public function getUserraining()
    {
        return $this->userraining;
    }

    /**
     * @return the $activity
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @return the $createdOn
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
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
     * @param \Training\Entity\UserTraining $userraining
     */
    public function setUserraining($userraining)
    {
        $this->userraining = $userraining;
        return $this;
    }

    /**
     * @param string $activity
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;
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

}

