<?php
namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This represent address phone number and other relevant details of the shop
 * @ORM\Entity
 * @ORM\Table(name="shop_details")
 * @author otaba
 *        
 */
class ShopDetails
{
    
    /**
     *
     * @var integer @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     *
     */
    private  $id;
    
    /**
     * @ORM\Column(name="phone", type="string", nullable=true)
     * @var string
     */
    private $phone;
    
    
    /**
     * @ORM\Column(name="email", type="string", nullable=true)
     * @var string
     */
    private $email;
    
    /**
     * @ORM\Column(name="address", type="text", nullable=true)
     * @var string
     */
    private $address;
    
    /**
     * @ORM\ManyToOne(targetEntity="Zone")
     * @var Zone
     */
    private $state;
    
    /**
     * @ORM\ManyToOne(targetEntity="Country")
     * @var Country
     */
    private $country;
    
    /**
     * @ORM\Column(name="terms", type="text", nullable=true)
     * @var string
     */
    private $terms;
    
    /**
     *  @ORM\Column(name="privacy_policy", type="text", nullable=true)
     * @var string
     */
    private $privacyPolicy;
   
    /**
     *  @ORM\Column(name="return_policy", type="text", nullable=true)
     * @var string
     */
    private $returnPolicy;
    
    /**
     *  @ORM\Column(name="shipping_info", type="text", nullable=true)
     * @var string
     */
    private $shippingInfo;

    // TODO - Insert your code here
    
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
     * @return the $phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return the $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return the $address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return the $state
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return the $country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return the $terms
     */
    public function getTerms()
    {
        return $this->terms;
    }

    /**
     * @return the $privacyPolicy
     */
    public function getPrivacyPolicy()
    {
        return $this->privacyPolicy;
    }

    /**
     * @return the $returnPolicy
     */
    public function getReturnPolicy()
    {
        return $this->returnPolicy;
    }

    /**
     * @return the $shippingInfo
     */
    public function getShippingInfo()
    {
        return $this->shippingInfo;
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
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @param \Settings\Entity\Zone $state
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @param \Settings\Entity\Country $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @param string $terms
     */
    public function setTerms($terms)
    {
        $this->terms = $terms;
        return $this;
    }

    /**
     * @param string $privacyPolicy
     */
    public function setPrivacyPolicy($privacyPolicy)
    {
        $this->privacyPolicy = $privacyPolicy;
        return $this;
    }

    /**
     * @param string $returnPolicy
     */
    public function setReturnPolicy($returnPolicy)
    {
        $this->returnPolicy = $returnPolicy;
        return $this;
    }

    /**
     * @param string $shippingInfo
     */
    public function setShippingInfo($shippingInfo)
    {
        $this->shippingInfo = $shippingInfo;
        return $this;
    }

    public function getFulladdress(){
        return "{$this->address},  {$this->getState()->getName()}, {$this->getCountry()->getName()}";
    }

}

