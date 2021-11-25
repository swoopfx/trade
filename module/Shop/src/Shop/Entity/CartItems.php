<?php
namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cart_items", indexes={@ORM\Index(name="id", columns={ "token", "product_id", })})
 * 
 * @author otaba
 *        
 */
class CartItems
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * A unique identifier for the cart
     * @ORM\Column(name="token", type="string", length=156, nullable=false)
     *
     * @var string
     */
    private $token;

    /**
     * The Product to be acquired
     *
     * @var Product @ORM\ManyToOne(targetEntity="Product")
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="Cart", inversedBy="cartItems")
     * 
     * @var Cart
     */
    private $cart;

    /**
     * A serailized content of the cart
     * Identified with numerous array key values
     * @ORM\Column(name="cart_content", type="text", length=65535, nullable=true)
     *
     * @var text
     */
    private $cartContent;

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
     * @return the $token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return the $product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return the $cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @return the $cartContent
     */
    public function getCartContent()
    {
        return $this->cartContent;
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
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @param \Shop\Entity\Product $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
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
     * @param string $cartContent
     */
    public function setCartContent($cartContent)
    {
        $this->cartContent = $cartContent;
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

}

