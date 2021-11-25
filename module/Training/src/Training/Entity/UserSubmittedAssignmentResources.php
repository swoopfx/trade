<?php
namespace Training\Entity;


use Doctrine\ORM\Mapping as ORM;
use Shop\Entity\Image;


/**
 * @ORM\Entity
 * @ORM\Table(name="user_submitted_assignement_resources")
 * @author mac
 *        
 */
class UserSubmittedAssignmentResources
{
    
    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Shop\Entity\Image")
     * @var Image
     */
    private $doument;
    
    /**
     * @ORM\ManyToOne(targetEntity="UserSubmittedTrainingAssignment", inversedBy="resourcess")
     * @var UserSubmittedTrainingAssignment
     */
    private $submmitedMilestone;
    
    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     * @var \DateTime
     */
    private $createdOn;
    
    

    // TODO - Insert your code here
    
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
     * @return the $doument
     */
    public function getDoument()
    {
        return $this->doument;
    }

    /**
     * @return the $submmitedMilestone
     */
    public function getSubmmitedMilestone()
    {
        return $this->submmitedMilestone;
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
     * @param \Shop\Entity\Image $doument
     */
    public function setDoument($doument)
    {
        $this->doument = $doument;
        return $this;
    }

    /**
     * @param \Training\Entity\UserSubmittedTrainingAssignment $submmitedMilestone
     */
    public function setSubmmitedMilestone($submmitedMilestone)
    {
        $this->submmitedMilestone = $submmitedMilestone;
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

