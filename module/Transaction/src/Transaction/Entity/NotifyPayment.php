<?php
namespace Transaction\Entity;

use Doctrine\ORM\Mapping as ORM;
use Shop\Entity\CartOrders;


/**
 * @ORM\Entity
 * @ORM\Table(name="notify_pament")
 * @author mac
 *        
 */
class NotifyPayment
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\Column(name="payment_uid", type="string", nullable=false)
     * @var string
     */
    private $paymentUid;
    
    /**
     * @ORM\Column(name="date_paid", type="datetime", nullable=false)
     * @var \DateTime
     */
    private $datePaid;
    
    /**
     * @ORM\Column(name="amount_paid", type="string", nullable=false)
     * @var string
     */
    private $amountPaid;
    
    /**
     * @ORM\Column(name="name_of_payee", type="string", nullable=true)
     * @var string
     */
    private $nameOfPayee;
    
    /**
     * @ORM\Column(name="payment_details", type="text", nullable=false)
     * @var string
     */
    private $paymentDetails;
    
    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     * @var \DateTime
     */
    private $createdOn;
    
    /**
     * @ORM\ManyToOne(targetEntity="Shop\Entity\CartOrders", inversedBy="notifyPayment")
     * @var CartOrders
     */
    private $cartOrder;
    
    /**
     * @return the $cartOrder
     */
    public function getCartOrder()
    {
        return $this->cartOrder;
    }

    /**
     * @param \Shop\Entity\CartOrders $cartOrder
     */
    public function setCartOrder($cartOrder)
    {
        $this->cartOrder = $cartOrder;
        return $this;
    }

    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $paymentUid
     */
    public function getPaymentUid()
    {
        return $this->paymentUid;
    }

    /**
     * @return the $datePaid
     */
    public function getDatePaid()
    {
        return $this->datePaid;
    }

    /**
     * @return the $amountPaid
     */
    public function getAmountPaid()
    {
        return $this->amountPaid;
    }

    /**
     * @return the $nameOfPayee
     */
    public function getNameOfPayee()
    {
        return $this->nameOfPayee;
    }

    /**
     * @return the $paymentDetails
     */
    public function getPaymentDetails()
    {
        return $this->paymentDetails;
    }

    /**
     * @return the $createdOn
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
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
     * @param string $paymentUid
     */
    public function setPaymentUid($paymentUid)
    {
        $this->paymentUid = $paymentUid;
        return $this;
    }

    /**
     * @param DateTime $datePaid
     */
    public function setDatePaid($datePaid)
    {
        $this->datePaid = $datePaid;
        return $this;
    }

    /**
     * @param string $amountPaid
     */
    public function setAmountPaid($amountPaid)
    {
        $this->amountPaid = $amountPaid;
        return $this;
    }

    /**
     * @param string $nameOfPayee
     */
    public function setNameOfPayee($nameOfPayee)
    {
        $this->nameOfPayee = $nameOfPayee;
        return $this;
    }

    /**
     * @param string $paymentDetails
     */
    public function setPaymentDetails($paymentDetails)
    {
        $this->paymentDetails = $paymentDetails;
        return $this;
    }

    /**
     * @param DateTime $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
}

