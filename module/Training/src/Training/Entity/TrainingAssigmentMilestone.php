<?php
namespace Training\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="training_assignment_milestone")
 * 
 * @author Ajayi Oluwaseun Ezekiel (ezekiel_a@yahoo.com)
 * @copyright 20 Jul 2021 I-Manager Solutions, Nigeria
 *            tanim_retailer
 *           
 *           
 */
class TrainingAssigmentMilestone
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\Column(name="milestone_uid", type="string", nullable=true)
     * @var string
     */
    private $milestoneUid;
    
    /**
     * @ORM\Column(name="topic", type="string", nullable=true)
     * @var string
     */
    private $topic;
    
    /**
     * @ORM\Column(name="descriptionss", type="text", nullable=true)
     * @var text
     */
    private $descriptions;
    
    /**
     * @ORM\Column(name="contentss", type="text", nullable=true)
     * @var text
     */
    private $content;
    
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
    
    /**
     * @ORM\ManyToOne(targetEntity="Training", inversedBy="trainingMilestone")
     * @var Training
     */
    private $training;
    
    /**
     * @ORM\OneToMany(targetEntity="TrainingMilestoneResources", mappedBy="milestone")
     * @var Collection
     */
    private $milestoneReources;
    
    public function __construct(){
        $this->milestoneReources = new ArrayCollection();
    }
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $topic
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @return the $descriptions
     */
    public function getDescriptions()
    {
        return $this->descriptions;
    }

    /**
     * @return the $content
     */
    public function getContent()
    {
        return $this->content;
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
     * @return the $training
     */
    public function getTraining()
    {
        return $this->training;
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
     * @param string $topic
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;
        return $this;
    }

    /**
     * @param \Training\Entity\text $descriptions
     */
    public function setDescriptions($descriptions)
    {
        $this->descriptions = $descriptions;
        return $this;
    }

    /**
     * @param \Training\Entity\text $content
     */
    public function setContent($content)
    {
        $this->content = $content;
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

    /**
     * @param \Training\Entity\Training $training
     */
    public function setTraining($training)
    {
        $this->training = $training;
        return $this;
    }
    /**
     * @return the $trainingReources
     */
    public function getTrainingReources()
    {
        return $this->trainingReources;
    }
    /**
     * @return the $milestoneReources
     */
    public function getMilestoneReources()
    {
        return $this->milestoneReources;
    }

//     /**
//      * @param \Doctrine\Common\Collections\Collection $milestoneReources
//      */
//     public function setMilestoneReources($milestoneReources)
//     {
//         $this->milestoneReources = $milestoneReources;
//         return $this;
//     }

    
   
    /**
     * @return the $milestoneUid
     */
    public function getMilestoneUid()
    {
        return $this->milestoneUid;
    }

    /**
     * @param string $milestoneUid
     */
    public function setMilestoneUid($milestoneUid)
    {
        $this->milestoneUid = $milestoneUid;
        return $this;
    }




}

