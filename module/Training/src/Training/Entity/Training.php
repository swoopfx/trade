<?php
namespace Training\Entity;

use Doctrine\ORM\Mapping as ORM;
use Shop\Entity\Image;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use CsnUser\Entity\User;

/**
 * @ORM\Entity(repositoryClass="Training\Entity\Repository\TrainingRepository")
 * @ORM\Table(name="training")
 *
 * @author otaba
 *        
 */
class Training
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="training_uid", type="string", nullable=false)
     *
     * @var string
     */
    private $trainingUid;

    /**
     * @ORM\Column(name="training_topic", type="string", nullable=true)
     *
     * @var string
     */
    private $trainingTopic;

    /**
     * @ORM\Column(name="training_description", type="text", nullable=true)
     *
     * @var longtext
     */
    private $trainingDescription;

    /**
     * @ORM\OneToMany(targetEntity="Training\Entity\Programmes", mappedBy="training", cascade={"remove"})
     *
     * @var Collection
     */
    private $programmes;

    /**
     * @ORM\ManyToOne(targetEntity="Shop\Entity\Image")
     *
     * @var Image
     */
    private $image;

    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $createdOn;

    /**
     * @ORM\Column(name="updated_on", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedOn;

    /**
     *
     * this is the point in form of currency that determines the reward attached to the completion of the project
     * @ORM\Column(name="training_points", type="string", nullable=true, options={"default": 0})
     * 
     * @var string
     *
     */
    private $trainingPoints = 0;

    /**
     * user subcribed to this training
     * @ORM\OneToMany(targetEntity="Training\Entity\UserTraining", mappedBy="training")
     *
     * @var Collection
     */
    private $subscriber;

    /**
     * Total Duration in hours
     *
     * @var string
     */
    private $duration;
    
    /**
     * @ORM\Column(name="is_published", type="boolean", options={"default": 0})
     * @var boolean
     */
    private $isPublished;
    
    /**
     * @ORM\OneToMany(targetEntity="Training\Entity\TrainingAssigmentMilestone", mappedBy="training")
     * @var Collection
     */
    private $trainingMilestone;
    
    

    /**
     */
    public function __construct()
    {
        $this->programmes = new ArrayCollection();
        $this->subscriber = new ArrayCollection();
        $this->trainingMilestone = new ArrayCollection();
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
     * @return the $trainingTopic
     */
    public function getTrainingTopic()
    {
        return $this->trainingTopic;
    }

    /**
     *
     * @return the $trainingDescription
     */
    public function getTrainingDescription()
    {
        return $this->trainingDescription;
    }

    /**
     *
     * @return the $image
     */
    public function getImage()
    {
        return $this->image;
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
     * @param string $trainingTopic            
     */
    public function setTrainingTopic($trainingTopic)
    {
        $this->trainingTopic = $trainingTopic;
        return $this;
    }

    /**
     *
     * @param \Training\Entity\unknown $trainingDescription            
     */
    public function setTrainingDescription($trainingDescription)
    {
        $this->trainingDescription = $trainingDescription;
        return $this;
    }

    /**
     *
     * @param \Shop\Entity\Image $image            
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
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
     *
     * @return ArrayCollection
     */
    public function getProgrammes()
    {
        return $this->programmes;
    }

    /**
     *
     * @param \Doctrine\Common\Collections\Collection $programmes            
     */
    public function setProgrammes($programmes)
    {
        $this->programmes = $programmes;
        return $this;
    }

    /**
     *
     * @param Programmes $programmes            
     * @return \Training\Entity\Training
     */
    public function addProgrammes(Programmes $programmes)
    {
        if (! $this->programmes->contains($programmes)) {
            $this->programmes->add($programmes);
            $programmes->setTraining($this);
        }
        return $this;
    }

    /**
     *
     * @param Programmes $programmes            
     * @return \Training\Entity\Training
     */
    public function removeProgrammes(Programmes $programmes)
    {
        if ($this->programmes->contains($programmes)) {
            $this->programmes->removeElement($programmes);
            $programmes->setTraining(NULL);
        }
        return $this;
    }

    /**
     *
     * @return the $trainingUid
     */
    public function getTrainingUid()
    {
        return $this->trainingUid;
    }

    /**
     *
     * @return the $trainingPoints
     */
    public function getTrainingPoints()
    {
        return $this->trainingPoints;
    }

    /**
     *
     * @return the $subscriber
     */
    public function getSubscriber()
    {
        return $this->subscriber;
    }

    /**
     *
     * @return the $duration
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     *
     * @param string $trainingUid            
     */
    public function setTrainingUid($trainingUid)
    {
        $this->trainingUid = $trainingUid;
        return $this;
    }

    /**
     *
     * @param string $trainingPoints            
     */
    public function setTrainingPoints($trainingPoints)
    {
        $this->trainingPoints = $trainingPoints;
        return $this;
    }

    /**
     *
     * @param UserTraining $subscriber            
     * @return \Training\Entity\Training
     */
    public function addSubscriber(UserTraining $subscriber)
    {
        if (! $this->subscriber->contains($subscriber)) {
            $this->subscriber[] = $subscriber;
            $subscriber->setTraining($this);
        }
        return $this;
    }

    /**
     *
     * @param UserTraining $subscriber            
     * @return \Training\Entity\Training
     */
    public function removeSubscriber(UserTraining $subscriber)
    {
        if ($this->subscriber->contains($subscriber)) {
            $this->subscriber->removeElement($subscriber);
            $subscriber->setTraining(NULL);
        }
        return $this;
    }

    /**
     *
     * @param string $duration            
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
        return $this;
    }
    /**
     * @return the $isPublished
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * @param boolean $isPublished
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;
        return $this;
    }
    /**
     * @return the $trainingMilestone
     */
    public function getTrainingMilestone()
    {
        return $this->trainingMilestone;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $subscriber
     */
    public function setSubscriber($subscriber)
    {
        $this->subscriber = $subscriber;
        return $this;
    }


}

