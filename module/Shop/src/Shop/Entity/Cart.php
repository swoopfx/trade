<?php
namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;
use CsnUser\Entity\User;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * At any instance there can only be one cart but many cart Item
 *
 * @ORM\Table(name="cart", indexes={@ORM\Index(name="id", columns={ "cart_uid" })})
 * @ORM\Entity
 */
class Cart
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="CartItems", mappedBy="cart")
     * 
     * @var Collection
     */
    private $cartItems;

    /**
     * @ORM\Column(name="cart_uid", type="string", nullable=true)
     * 
     * @var string
     */
    private $cartUid;

    /**
     * Identifies if the cart has been checkout or not 
     * @ORM\Column(name="is_settled", type="boolean", nullable=true)
     *
     * @var boolean
     */
    private $isSettled;

    /**
     * User requesting for the acquisition
     * @ORM\ManyToOne(targetEntity="CsnUser\Entity\User")
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     *
     * @var \DateTime
     */
    private $createdOn;

    /**
     * @ORM\Column(name="updated_on", type="datetime", nullable=false)
     *
     * @var \DateTime
     */
    private $updatedOn;
    
    /**
     * If this is true the billing address is used forshipping address
     * @ORM\Column(name="is_use_billing", type="boolean", nullable=true)
     * @var boolean
     */
    private $isUseBilling;

    public function __construct()
    {
        $this->cartItems = new ArrayCollection();
    }
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $cartItems
     */
    public function getCartItems()
    {
        return $this->cartItems;
    }

    /**
     * @return the $cartUid
     */
    public function getCartUid()
    {
        return $this->cartUid;
    }

    /**
     * @return the $isSettled
     */
    public function getIsSettled()
    {
        return $this->isSettled;
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

//     /**
//      * @param \Doctrine\Common\Collections\Collection $cartItems
//      */
//     public function setCartItems($cartItems)
//     {
//         $this->cartItems = $cartItems;
//         return $this;
//     }

    /**
     * 
     * @param CartItems $cartitem
     * @return \Shop\Entity\Cart
     */
    public function addCartItems(CartItems $cartitem){
        if(!$this->cartItems->contains($cartitem)){
            $this->cartItems[] = $cartitem;
            $cartitem->setCart($this);
            
        }
        return $this;
    }
    
    /**
     * 
     * @param CartItems $cartItem
     * @return \Shop\Entity\Cart
     */
    public function removeCartItems(CartItems $cartItem){
        if($this->cartItems->contains($cartItem)){
            $this->cartItems->remove($cartItem);
            $cartItem->setCart(NULL);
        }
        return $this;
    }

    /**
     * @param string $cartUid
     */
    public function setCartUid($cartUid)
    {
        $this->cartUid = $cartUid;
        return $this;
    }

    /**
     * @param boolean $isSettled
     */
    public function setIsSettled($isSettled)
    {
        $this->isSettled = $isSettled;
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
     * @return the $isUseBilling
     */
    public function getIsUseBilling()
    {
        return $this->isUseBilling;
    }

    /**
     * @param boolean $isUseBilling
     */
    public function setIsUseBilling($isUseBilling)
    {
        $this->isUseBilling = $isUseBilling;
        return $this;
    }


}
