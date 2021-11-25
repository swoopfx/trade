<?php
namespace Support\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="support_messages")
 *
 * @author otaba
 *        
 */
class SupportMessages
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="message_text", type="text", nullable=false)
     *
     * @var text
     */
    private $messageText;

    /**
     * @ORM\ManyToOne(targetEntity="Support", inversedBy="conversation")
     *
     * @var Support
     */
    private $messages;

    /**
     * @ORM\Column(name="is_read", type="boolean", nullable=true, options={"default" : 0})
     *
     * @var boolean
     */
    private $isRead;

    /**
     * @ORM\ManyToOne(targetEntity="SupportMessageState")
     *
     * @var SupportMessageState
     */
    private $userState;

    /**
     * @ORM\ManyToOne(targetEntity="SupportMessageState")
     *
     * @var SupportMessageState
     */
    private $adminState;

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
     * @ORM\ManyToOne(targetEntity="SupportStatus")
     *
     * @var SupportStatus
     *
     */
    private $supportStatus;

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
     * @return the $messageText
     */
    public function getMessageText()
    {
        return $this->messageText;
    }

    /**
     *
     * @return the $messages
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     *
     * @return the $isRead
     */
    public function getIsRead()
    {
        return $this->isRead;
    }

    /**
     *
     * @return the $userState
     */
    public function getUserState()
    {
        return $this->userState;
    }

    /**
     *
     * @return the $adminState
     */
    public function getAdminState()
    {
        return $this->adminState;
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
     * @return the $supportStatus
     */
    public function getSupportStatus()
    {
        return $this->supportStatus;
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
     * @param \Support\Entity\text $messageText            
     */
    public function setMessageText($messageText)
    {
        $this->messageText = $messageText;
        return $this;
    }

    /**
     *
     * @param \Support\Entity\Support $messages            
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
        return $this;
    }

    /**
     *
     * @param boolean $isRead            
     */
    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;
        return $this;
    }

    /**
     *
     * @param \Support\Entity\SupportMessageState $userState            
     */
    public function setUserState($userState)
    {
        $this->userState = $userState;
        return $this;
    }

    /**
     *
     * @param \Support\Entity\SupportMessageState $adminState            
     */
    public function setAdminState($adminState)
    {
        $this->adminState = $adminState;
        return $this;
    }

    /**
     *
     * @param DateTime $createdOn            
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        $this->updatedOn = $createdOn;
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
     * @param \Support\Entity\SupportStatus $supportStatus            
     */
    public function setSupportStatus($supportStatus)
    {
        $this->supportStatus = $supportStatus;
        return $this;
    }
}

