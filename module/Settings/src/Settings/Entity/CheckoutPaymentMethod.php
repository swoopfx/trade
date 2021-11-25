<?php
namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pay with flutter wave
 * Pay with Monnify
 * Pay with Paystack
 * Bank Payment
 * 
 * @ORM\Entity
 * @ORM\Table(name="checkout_payment_method")
 * @author ezekiel
 *        
 */
class CheckoutPaymentMethod
{
    
    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\Column(name="payment_method", type="string", nullable=true)
     * @var string
     */
    private $paymentMethod;
    
    
    /**
     * @ORM\Column(name="logo", type="string", nullable=true)
     * @var string
     */
    private $logo;
    
    /**
     * @ORM\Column(name="is_active", type="boolean", nullable=false, options={"default":"1"})
     * @var boolean
     */
    private $isActive;

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
     * @return the $paymentMethod
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @return the $isActive
     */
    public function getIsActive()
    {
        return $this->isActive;
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
     * @param string $paymentMethod
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
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
     * @return the $logo
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
        return $this;
    }


}

