<?php
namespace Bbmin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Training\Entity\UserTraining;

/**
 * @ORM\Entity(repositoryClass="Bbmin\Entity\Repository\AdminSubmittedAssignmentRepository")
 * @ORM\Table(name="admin_submitted_assignment")
 * @author mac
 *        
 */
class AdminSubmittedAssignment
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Training\Entity\UserTraining")
     * @var UserTraining
     */
    private $userTraining;
    
    /**
     * @ORM\ManyToOne(targetEntity="AdminSubmittedAssignmentStatus")
     * @var  AdminSubmittedAssignmentStatus
     */
    private $status;
    
    /**
     * @ORM\Column(name="is_disbursed", type="boolean", nullable=true)
     * @var boolean
     */
    private $isDisbursed;
    
    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     * @var \DateTime
     */
    private $createdOn;
    
    /**
     * @ORM\Column(name="updated_on", type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updateOn;
    
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
     * @return the $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return the $isDisbursed
     */
    public function getIsDisbursed()
    {
        return $this->isDisbursed;
    }

    /**
     * @return the $createdOn
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @return the $updateOn
     */
    public function getUpdateOn()
    {
        return $this->updateOn;
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
     * @param \Bbmin\Entity\AdminSubmittedAssignmentStatus $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param boolean $isDisbursed
     */
    public function setIsDisbursed($isDisbursed)
    {
        $this->isDisbursed = $isDisbursed;
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
     * @param DateTime $updateOn
     */
    public function setUpdateOn($updateOn)
    {
        $this->updateOn = $updateOn;
        return $this;
    }

}

