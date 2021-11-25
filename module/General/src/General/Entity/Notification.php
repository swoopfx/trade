<?php
namespace General\Entity;

use Doctrine\ORM\Mapping as ORM;
use CsnUser\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="notification")
 *
 * @author otaba
 *        
 */
class Notification
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     *     
     */
    private $id;

    /**
     * @ORM\Column(name="topic", type="string", nullable=false)
     *
     * @var unknown
     */
    private $topic;

    /**
     * @ORM\Column(name="message", type="text", nullable=true)
     *
     * @var string
     */
    private $message;

    /**
     * Recipient of the notiification
     * @ORM\ManyToOne(targetEntity="CsnUser\Entity\User")
     *
     * @var User
     */
    private $beingFor;

    // private $
    
    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     *
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
     *
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return the $topic
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     *
     * @return the $message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     *
     * @return the $beingFor
     */
    public function getBeingFor()
    {
        return $this->beingFor;
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
     * @param number $id            
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @param \General\Entity\unknown $topic            
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;
        return $this;
    }

    /**
     *
     * @param string $message            
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     *
     * @param \CsnUser\Entity\User $beingFor            
     */
    public function setBeingFor($beingFor)
    {
        $this->beingFor = $beingFor;
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
}

