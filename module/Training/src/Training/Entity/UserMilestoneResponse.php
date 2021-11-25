<?php
namespace Training\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Shop\Entity\Image;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_milestone_response")
 *
 * @author Ajayi Oluwaseun Ezekiel (ezekiel_a@yahoo.com)
 * @copyright 20 Jul 2021 I-Manager Solutions, Nigeria
 *            tanim_retailer
 *           
 *           
 */
class UserMilestoneResponse
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var TrainingAssigmentMilestone
     */
    private $trainingMilestone;

    /**
     * @ORM\Column(name="user_response", type="text", nullable=true)
     *
     * @var text
     */
    private $userResponse;

    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $createdOn;

    /**
     * @ORM\ManyToMany(targetEntity="Shop\Entity\Image")
     * @ORM\JoinTable(name="user_milestone_resource_image", joinColumns={@ORM\JoinColumn(name="user_milestone_resource_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="image_id", referencedColumnName="id", unique=true)})
     *
     * @var Collection
     */
    private $document;

    /**
     */
    public function __construct()
    {
        $this->document = new ArrayCollection();
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
     * @return the $trainingMilestone
     */
    public function getTrainingMilestone()
    {
        return $this->trainingMilestone;
    }

    /**
     *
     * @return the $userResponse
     */
    public function getUserResponse()
    {
        return $this->userResponse;
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
     * @return the $document
     */
    public function getDocument()
    {
        return $this->document;
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
     * @param \Training\Entity\TrainingAssigmentMilestone $trainingMilestone            
     */
    public function setTrainingMilestone($trainingMilestone)
    {
        $this->trainingMilestone = $trainingMilestone;
        return $this;
    }

    /**
     *
     * @param \Training\Entity\text $userResponse            
     */
    public function setUserResponse($userResponse)
    {
        $this->userResponse = $userResponse;
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
     * @param \Doctrine\Common\Collections\Collection $document            
     */
    public function setDocument($document)
    {
        $this->document = $document;
        return $this;
    }

    /**
     *
     * @param Image $document            
     * @return \Training\Entity\UserMilestoneResponse
     */
    public function addDocument(Image $document)
    {
        if (! $this->document->contains($document)) {
            $this->document->add($document);
        }
        return $this;
    }

    public function removeDocument(Image $document)
    {
        if ($this->document->contains($document)) {
            $this->document->removeElement($document);
        }
        return $this;
    }
}

