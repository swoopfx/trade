<?php
namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;
use CsnUser\Entity\User;
use Settings\Entity\Zone;
use Settings\Entity\Country;

/**
 * This is used as a delivery address
 * @ORM\Entity
 * @ORM\Table(name="order_billing_details")
 * @author otaba
 *        
 */
class BillingDetails
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
 
    /**
     * @ORM\Column(name="billing_address1", type="string", nullable=true)
     * @var string
     */
    private $billingAddress1;
    
    /**
     * @ORM\Column(name="billing_address2", type="string", nullable=true)
     * @var string
     */
    private $billingAddress2;
    
    /**
     * @ORM\Column(name="billing_city", type="string", nullable=true)
     * @var string
     */
    private $billingCity;
    
    /**
     * @ORM\ManyToOne(targetEntity="Settings\Entity\Country")
     * @var Country
     */
    private $billingCountry; // must be NIgeria
    
    /**
     * @ORM\OneToOne(targetEntity="CsnUser\Entity\User")
     * @var User
     */
    private $user;
    
    /**
     * @ORM\ManyToOne(targetEntity="Settings\Entity\Zone")
     * @var Zone
     */
    private $zone;
    
    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     * @var \DateTime
     */
    private $createdOn;
    
    /**
     * @ORM\Column(name="updated_on", type="datetime", nullable=false)
     * @var \DateTime
     */
    private $updatedOn;
    
    
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $billingfirstName
     */
    public function getBillingfirstName()
    {
        return $this->billingfirstName;
    }

    /**
     * @return the $billingLastName
     */
    public function getBillingLastName()
    {
        return $this->billingLastName;
    }

    /**
     * @return the $billingAddress1
     */
    public function getBillingAddress1()
    {
        return $this->billingAddress1;
    }

    /**
     * @return the $billingAddress2
     */
    public function getBillingAddress2()
    {
        return $this->billingAddress2;
    }

    /**
     * @return the $billingCity
     */
    public function getBillingCity()
    {
        return $this->billingCity;
    }

    /**
     * @return the $billingCountry
     */
    public function getBillingCountry()
    {
        return $this->billingCountry;
    }

    /**
     * @return the $user
     */
    public function getUser()
    {
        return $this->user;
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
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param DateTime $billingfirstName
     */
    public function setBillingfirstName($billingfirstName)
    {
        $this->billingfirstName = $billingfirstName;
        return $this;
    }

    /**
     * @param field_type $billingLastName
     */
    public function setBillingLastName($billingLastName)
    {
        $this->billingLastName = $billingLastName;
        return $this;
    }

    /**
     * @param field_type $billingAddress1
     */
    public function setBillingAddress1($billingAddress1)
    {
        $this->billingAddress1 = $billingAddress1;
        return $this;
    }

    /**
     * @param field_type $billingAddress2
     */
    public function setBillingAddress2($billingAddress2)
    {
        $this->billingAddress2 = $billingAddress2;
        return $this;
    }

    /**
     * @param field_type $billingCity
     */
    public function setBillingCity($billingCity)
    {
        $this->billingCity = $billingCity;
        return $this;
    }

    /**
     * @param field_type $billingCountry
     */
    public function setBillingCountry($billingCountry)
    {
        $this->billingCountry = $billingCountry;
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
     * @param DateTime $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        $this->updatedOn = $createdOn;
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
     * @return the $zone
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * @param \Settings\Entity\Zone $zone
     */
    public function setZone($zone)
    {
        $this->zone = $zone;
        return $this;
    }


}

