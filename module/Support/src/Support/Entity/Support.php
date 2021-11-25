<?php
namespace Support\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use CsnUser\Entity\User;

/**
 * @ORM\Entity(repositoryClass="Support\Entity\Repository\SupportRepository")
 * @ORM\Table(name="retaile_support")
 *
 * @author otaba
 *        
 */
class Support
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="support_title", type="string", nullable=true)
     *
     * @var string
     */
    private $supportTitle;

    /**
     * @ORM\Column(name="support_uid", type="string", nullable=true)
     *
     * @var string
     */
    private $supportUid;

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
     *
     */
    private $updatedOn;

    /**
     * @ORM\OneToMany(targetEntity="SupportMessages", mappedBy="messages", cascade={"persist", "remove"})
     *
     * @var Collection
     */
    private $conversation;

    /**
     * @ORM\ManyToOne(targetEntity="CsnUser\Entity\User", inversedBy="support")
     *
     * @var User
     */
    private $user;

    /**
     * if true the user just updated a recent information and has not been viewd
     * @ORM\Column(name="is_active", type="boolean", nullable=false, options={"default"="0"})
     * 
     * @var boolean
     */
    private $isActive;
    
    /**
     * @ORM\ManyToOne(targetEntity="SupportStatus")
     * @var SupportStatus;
     */
    private $status;

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        $this->conversation = new ArrayCollection();
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
     * @return the $supportTitle
     */
    public function getSupportTitle()
    {
        return $this->supportTitle;
    }

    /**
     *
     * @return the $supportUid
     */
    public function getSupportUid()
    {
        return $this->supportUid;
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
     * @return the $conversation
     */
    public function getConversation()
    {
        return $this->conversation;
    }

    /**
     *
     * @return the $user
     */
    public function getUser()
    {
        return $this->user;
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
     * @param string $supportTitle            
     */
    public function setSupportTitle($supportTitle)
    {
        $this->supportTitle = $supportTitle;
        return $this;
    }

    /**
     *
     * @param string $supportUid            
     */
    public function setSupportUid($supportUid)
    {
        $this->supportUid = $supportUid;
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
     * @param SupportMessages $conversation            
     */
    public function addConversation($conversation)
    {
        if (! $this->conversation->contains($conversation)) {
            $this->conversation->add($conversation);
        }
        
        return $this;
    }

    /**
     *
     * @param SupportMessages $conversation            
     */
    public function removeConversation(SupportMessages $converstaion)
    {
        if ($this->conversation->contains($converstaion)) {
            $this->conversation->removeElement($converstaion);
            $converstaion->setMessages(NULL);
        }
        return $this;
    }

    /**
     *
     * @param \CsnUser\Entity\User $user            
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }
    /**
     * @return the $isActive
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }
    /**
     * @return the $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param \Support\Entity\SupportStatus; $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }


}

