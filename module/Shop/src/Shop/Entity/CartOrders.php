<?php
namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;
use Transaction\Entity\Invoice;
use CsnUser\Entity\User;
use Shop\Entity\Cart;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Settings\Entity\Tax;
use Settings\Entity\CheckoutPaymentMethod;

/**
 * CartOrders
 *
 * @ORM\Table(name="cart_order")
 * @ORM\Entity(repositoryClass="Shop\Entity\Repository\OrderRepository")
 */
class CartOrders
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\Column(name="order_uid", type="string", nullable=false)
     * @var string
     */
    private $orderUid;

    /**
     *
     * @var Invoice @ORM\ManyToOne(targetEntity="Transaction\Entity\Invoice")
     */
    private $invoice;

    /**
     * @ORM\ManyToOne(targetEntity="Shop\Entity\Cart")
     *
     * @var Cart
     */
    private $cart;
    
//     /**
//      * @ORM\Column(name="price", type="decimal", precision=15, scale=4, nullable=false, options={"default"="0.0000"})
//      * @var string
//      */
//     private $price;
    
    /**
     * 
     * @var Tax
     */
    private $tax;
    
    /**
     * @ORM\ManyToOne(targetEntity="OrderDeliveryType")
     * @var OrderDeliveryType
     */
    private $deliveryType;

//     /**
//      * @ORM\ManyToOne(targetEntity="CsnUser\Entity\User")
//      *
//      * @var User
//      */
//     private $user;

    /**
     * Total payable for the garment
     * @var string 
     * @ORM\Column(name="total", type="decimal", precision=15, scale=4, nullable=false, options={"default"="0.0000"})
     */
    private $total = '0.0000';

    /**
     * @ORM\ManyToOne(targetEntity="OrderStatus")
     *
     * @var OrderStatus
     */
    private $orderStatus;

    /**
     * @ORM\OneToMany(targetEntity="OrderTracking", mappedBy="order")
     *
     * @var Collection
     */
    private $tracking;

    /**
     *
     * @var string @ORM\Column(name="ip", type="string", length=40, nullable=true)
     */
    private $ip;

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
     * @ORM\Column(name="is_closed", type="boolean", nullable=false, options={"default":"0"})
     * @var boolean
     */
    private $isClosed;
    
    /**
     *  @ORM\Column(name="deliveryPrice", type="decimal", precision=15, scale=4, nullable=true, options={"default"="0.0000"})
     * @var string
     */
    private $deliveryPrice;
    
    /**
     * @ORM\Column(name="is_discount", type="boolean", nullable=true, options={"default":"0"})
     * @var boolean
     */
    private $isDiscount;
    
    /**
     *  @ORM\Column(name="discount_value", type="decimal", precision=15, scale=4, nullable=true, options={"default"="0.0000"})
     * @var string
     */
    private $discountValue;
    
    /**
     * @ORM\ManyToOne(targetEntity="Settings\Entity\CheckoutPaymentMethod")
     * @var CheckoutPaymentMethod
     */
    private $paymentMethod;
    
    /**
     * @ORM\OneToMany(targetEntity="Transaction\Entity\NotifyPayment", mappedBy="cartOrder")
     * @var Collection
     */
    private $notifyPayment;

    
//     private $
    
    public function __construct(){
        $this->tracking = new ArrayCollection();
        $this->notifyPayment = new ArrayCollection();
    }
    
    
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * @return the $cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @return the $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return the $total
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return the $orderStatus
     */
    public function getOrderStatus()
    {
        return $this->orderStatus;
    }

    /**
     * @return the $tracking
     */
    public function getTracking()
    {
        return $this->tracking;
    }

    /**
     * @return the $ip
     */
    public function getIp()
    {
        return $this->ip;
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
     * @param \Transaction\Entity\Invoice $invoice
     */
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;
        return $this;
    }

    /**
     * @param \Shop\Entity\Cart $cart
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
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
     * @param string $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @param \Shop\Entity\OrderStatus $orderStatus
     */
    public function setOrderStatus($orderStatus)
    {
        $this->orderStatus = $orderStatus;
        return $this;
    }

//     /**
//      * @param \Doctrine\Common\Collections\Collection $tracking
//      */
//     public function setTracking($tracking)
//     {
//         $this->tracking = $tracking;
//         return $this;
//     }
    
    /**
     * 
     * @param OrderTracking $tracking
     * @return \Shop\Entity\CartOrders
     */
    public function addTracking(OrderTracking $tracking){
        if(!$this->tracking->contains($tracking)){
            $this->tracking[] = $tracking;
            $tracking->setOrder($this);
        }
        return $this;
    }
    
    /**
     * 
     * @param OrderTracking $tracking
     * @return \Shop\Entity\CartOrders
     */
    public function removeTracking(OrderTracking $tracking){
        if($this->tracking->contains($tracking)){
            $this->tracking->removeElement($tracking);
            $tracking->setOrder(NULL);
        }
        return $this;
    }

    /**
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
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
     * @param DateTime $updatedOn
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;
        return $this;
    }

    /**
     * @return bools
     */
    public function getIsClosed()
    {
        return $this->isClosed;
    }

    /**
     * @param bool $isClosed
     * @return CartOrders
     */
    public function setIsClosed($isClosed)
    {
        $this->isClosed = $isClosed;
        return $this;
    }
    /**
     * @return the $orderUid
     */
    public function getOrderUid()
    {
        return $this->orderUid;
    }

    /**
     * @param string $orderUid
     */
    public function setOrderUid($orderUid)
    {
        $this->orderUid = $orderUid;
        return $this;
    }
    /**
     * @return the $deliveryType
     */
    public function getDeliveryType()
    {
        return $this->deliveryType;
    }

    /**
     * @param \Shop\Entity\OrderDeliveryType $deliveryType
     */
    public function setDeliveryType($deliveryType)
    {
        $this->deliveryType = $deliveryType;
        return $this;
    }
    /**
     * @return the $tax
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @return the $deliveryPrice
     */
    public function getDeliveryPrice()
    {
        return $this->deliveryPrice;
    }

    /**
     * @param \Settings\Entity\Tax $tax
     */
    public function setTax($tax)
    {
        $this->tax = $tax;
        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $tracking
     */
    public function setTracking($tracking)
    {
        $this->tracking = $tracking;
        return $this;
    }

    /**
     * @param string $deliveryPrice
     */
    public function setDeliveryPrice($deliveryPrice)
    {
        $this->deliveryPrice = $deliveryPrice;
        return $this;
    }
    /**
     * @return the $isDiscount
     */
    public function getIsDiscount()
    {
        return $this->isDiscount;
    }

    /**
     * @return the $discountValue
     */
    public function getDiscountValue()
    {
        return $this->discountValue;
    }

    /**
     * @param boolean $isDiscount
     */
    public function setIsDiscount($isDiscount)
    {
        $this->isDiscount = $isDiscount;
        return $this;
    }

    /**
     * @param string $discountValue
     */
    public function setDiscountValue($discountValue)
    {
        $this->discountValue = $discountValue;
        return $this;
    }
    /**
     * @return the $paymentMethod
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param \Settings\Entity\CheckoutPaymentMethod $paymentMethod
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }
    /**
     * @return the $notifyPayment
     */
    public function getNotifyPayment()
    {
        return $this->notifyPayment;
    }







}
