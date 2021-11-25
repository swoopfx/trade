<?php
namespace Transaction\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bank Transfer
 * Card
 * USSD
 * Payment On Delivery
 * 
 * @ORM\Entity
 * @ORM\Table(name="payment_method")
 * 
 * @author otaba
 *        
 */
class PaymentMethod
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="method", type="string", nullable=true)
     * 
     * @var string
     */
    private $method;

    /**
     * @ORM\Column(name="code", type="string", nullable=true)
     * 
     * @var string
     */
    private $code;

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
     * @return the $method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return the $code
     */
    public function getCode()
    {
        return $this->code;
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
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

}

