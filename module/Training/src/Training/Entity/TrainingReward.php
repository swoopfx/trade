<?php
namespace Training\Entity;
use Doctrine\ORM\Mapping as ORM;
use CsnUser\Entity\User;

/**
 * 
 * @author Ajayi Oluwaseun Ezekiel (ezekiel_a@yahoo.com)
 *@copyright 21 Mar 2021 I-Manager Solutions, Nigeria
 * Tfits online 
 * @ORM\Entity
 * @ORM\Table(name="training_reward")
 *
 */
class TrainingReward
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
     * @var Training
     */
    private $training;
    
    /**
     * @ORM\ManyToOne(targetEntity="CsnUser\Entity\User")
     * @var User
     */
    private $user;
    
    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     * @var \DateTime
     */
    private $createdOn;
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
     * @return the $user
     */
    public function getUser()
    {
        return $this->user;
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
     * @param \CsnUser\Entity\User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }
    /**
     * @return the $createdOn
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
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

