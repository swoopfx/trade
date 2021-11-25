<?php
namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Settings\Entity\IdentityType;
use CsnUser\Entity\User;
use Settings\Entity\UserLevel;
use Settings\Entity\Zone;
use Settings\Entity\Country;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="retailer_user_profile")
 *
 * @author otaba
 *        
 */
class UserProfile
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
     *
     * @ORM\Column(name="firstname", type="string", nullable=true)
     *
     * @var string
     */
    private $firstname;

    /**
     * @ORM\Column(name="lastname", type="string", nullable=true)
     *
     * @var string
     */
    private $lastname;

    /**
     *
     * @ORM\Column(name="dob", type="datetime", nullable=true)
     *
     * @var string
     */
    private $dob;

    /**
     *
     * @ORM\Column(name="bvn", type="string", nullable=true)
     *
     * @var string
     */
    private $bvn;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Settings\Entity\IdentityType")
     *
     * @var IdentityType
     */
    private $identityType;

    /**
     *
     * @ORM\Column(name="identity", type="string", nullable=true)
     *
     * @var string;
     */
    private $identity;

    /**
     * @ORM\OneToOne(targetEntity="CsnUser\Entity\User", inversedBy="profile")
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(name="address", type="string", nullable=true)
     * 
     * @var string
     */
    private $address1;
    
    private $address2;

    /**
     * @ORM\ManyToOne(targetEntity="Settings\Entity\Zone")
     * 
     * @var Zone
     */
    private $state;
    
//     /**
//      * Defines localgovernment area
//      * @var unknown
//      */
//     private $lga;

    /**
     * @ORM\ManyToOne(targetEntity="Settings\Entity\Country")
     * 
     * @var Country
     */
    private $country;

    private $guarators;

    /**
     * @ORM\ManyToOne(targetEntity="Settings\Entity\UserLevel")
     *
     * @var UserLevel
     */
    private $userLevel;

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

    // TODO - Insert your code here
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    /**
     *
     * @return number
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     *
     * @return string
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     *
     * @return string
     */
    public function getBvn()
    {
        return $this->bvn;
    }

    /**
     *
     * @return \Settings\Entity\IdentityType
     */
    public function getIdentityType()
    {
        return $this->identityType;
    }

    /**
     *
     * @return \User\src\User\Entity\string;
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     *
     * @return mixed
     */
    public function getGuarators()
    {
        return $this->guarators;
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
     * @param string $firstname            
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     *
     * @param string $lastname            
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     *
     * @param string $dob            
     */
    public function setDob($dob)
    {
        $this->dob = $dob;
        return $this;
    }

    /**
     *
     * @param string $bvn            
     */
    public function setBvn($bvn)
    {
        $this->bvn = $bvn;
        return $this;
    }

    /**
     *
     * @param \Settings\Entity\IdentityType $identityType            
     */
    public function setIdentityType($identityType)
    {
        $this->identityType = $identityType;
    }

    /**
     *
     * @param string; $identity            
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
        return $this;
    }

    /**
     *
     * @param mixed $guarators            
     */
    public function setGuarators($guarators)
    {
        $this->guarators = $guarators;
        return $this;
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
     * @param \CsnUser\Entity\User $user            
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
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
     * @return the $userLevel
     */
    public function getUserLevel()
    {
        return $this->userLevel;
    }

    /**
     *
     * @param \Settings\Entity\UserLevel $userLevel            
     */
    public function setUserLevel($userLevel)
    {
        $this->userLevel = $userLevel;
        return $this;
    }

    /**
     *
     * @return the $address1
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     *
     * @return the $state
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     *
     * @return the $country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     *
     * @param string $address1            
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;
        return $this;
    }

    /**
     *
     * @param \Settings\Entity\Zone $state            
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     *
     * @param \Settings\Entity\Country $country            
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    public function getFullAddress()
    {
        return ($this->address1 != NULL ? $this->address1 : "") . " " . ($this->state != NULL ? $this->state->getName() : "") . " " . ($this->country != NULL ? $this->country->getName() : "");
    }

    public function getFullName(){
        return "{$this->lastname} {$this->firstname}";
    }
}

