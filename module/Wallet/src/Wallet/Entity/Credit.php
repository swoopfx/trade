<?php
namespace Wallet\Entity;

use Doctrine\ORM\Mapping as ORM;
use CsnUser\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="retialer_credit")
 *
 * @author otaba
 *        
 */
class Credit
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * This is the maximum credit limit avaible to this user 
     * @ORM\Column(name="credit_limit", type="string", nullable=false)
     *
     * @var string
     */
    private $creditLimit;

    /**
     * Availaible bonus availaible to this customer 
     * @ORM\Column(name="credit_bonus", type="string", nullable=true)
     *
     * @var string
     */
    private $creditBonus;

    /**
     * @ORM\OneToOne(targetEntity="CsnUser\Entity\User", inversedBy="credit")
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(name="credit_uid", type="string", nullable=true)
     * 
     * @var string
     */
    private $credituid;

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
    private $updateOn;

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
     * @return the $creditLimit
     */
    public function getCreditLimit()
    {
        return $this->creditLimit;
    }

    /**
     *
     * @return the $creditBonus
     */
    public function getCreditBonus()
    {
        return $this->creditBonus;
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
     * @return the $createdOn
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     *
     * @return the $updateOn
     */
    public function getUpdateOn()
    {
        return $this->updateOn;
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
     * @param string $creditLimit            
     */
    public function setCreditLimit($creditLimit)
    {
        $this->creditLimit = $creditLimit;
        return $this;
    }

    /**
     *
     * @param string $creditBonus            
     */
    public function setCreditBonus($creditBonus)
    {
        $this->creditBonus = $creditBonus;
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
     *
     * @param DateTime $createdOn            
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        $this->createdOn = $createdOn;
        return $this;
    }

    /**
     *
     * @param DateTime $updateOn            
     */
    public function setUpdateOn($updateOn)
    {
        $this->updateOn = $updateOn;
        return $this;
    }
    /**
     * @return the $credituid
     */
    public function getCredituid()
    {
        return $this->credituid;
    }

    /**
     * @param string $credituid
     */
    public function setCredituid($credituid)
    {
        $this->credituid = $credituid;
        return $this;
    }

}

