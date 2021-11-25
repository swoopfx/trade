<?php
namespace Training\Entity;

use Doctrine\ORM\Mapping as ORM;
use Shop\Entity\Image;

/**
 * 
 * @author Ajayi Oluwaseun Ezekiel (ezekiel_a@yahoo.com)
 *@copyright 27 Jun 2021 I-Manager Solutions, Nigeria
 * tanim_retail
 * @ORM\Entity
 * @ORM\Table(name="training_milestone_resources")
 *
 *
 */
class TrainingMilestoneResources
{
    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\Column(name="namess", type="string", nullable=true)
     * @var string
     */
    private $name;
    
    /**
     * @ORM\ManyToOne(targetEntity="Shop\Entity\Image")
     * @var Image
     */
    private $document;
    
    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     * @var \DateTime
     */
    private $createdOn;
    
    /**
     * @ORM\ManyToOne(targetEntity="TrainingAssigmentMilestone", inversedBy="milestoneReources")
     * @var TrainingAssigmentMilestone
     */
    private $milestone;
    
//     private $

    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return the $document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @return the $createdOn
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @return the $milestone
     */
    public function getMilestone()
    {
        return $this->milestone;
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
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param \Shop\Entity\Image $document
     */
    public function setDocument($document)
    {
        $this->document = $document;
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
     * @param \Training\Entity\TrainingAssigmentMilestone $milestone
     */
    public function setMilestone($milestone)
    {
        $this->milestone = $milestone;
        return $this;
    }
}

