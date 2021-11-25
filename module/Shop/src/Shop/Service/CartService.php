<?php
namespace Shop\Service;

use General\Service\GeneralService;
use Doctrine\ORM\EntityManager;
use Laminas\Session\Container;
use Laminas\Authentication\AuthenticationService;
use Shop\Entity\Cart;
use Shop\Entity\CartItems;
use CsnUser\Entity\User;

/**
 *
 * @author otaba
 *        
 */
class CartService
{

    /**
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var Container
     */
    private $shoppingSession;

    /**
     *
     * @var AuthenticationService
     */
    private $auth;

    /**
     *
     * @var string
     */
    private $userId;

    /**
     *
     * @var array
     */
    private $cart;

    private $items;

    private $contents;

    private $isEmpty;

    private $totalItems;

    private $totalQty;

    /**
     *
     * @var CartItems
     */
    private $cartItemEntity;

    /**
     *
     * @var CartItemService
     */
    private $cartItemService;

    /**
     *
     * @var Cart
     */
    private $cartEntity;

    private $unitOfWork;

    private function generateCartUid()
    {
        return uniqid("cart");
    }

    public function execute()
    {
        $this->unitOfWork->flush();
    }

    public function __construct()
    {
        $this->items = array();
    }

    public function __get($value)
    {
        switch ($value) {
            case "contents":
                return $this->items;
                break;
        }
    }

    // public function getCartItems(){
    
    // }
    
    /**
     * This is synonymous to removeall function
     * It clears the whole cart
     *
     * @return boolean
     */
    public function clearCart()
    {
        $shoppingSession = $this->shoppingSession;
        $shoppingSession->offsetUnset("cart" . $this->userId);
        if ($shoppingSession == null) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * This gets the present cart entity of the user
     *
     * @return this
     */
    public function getCart()
    {
        $em = $this->entityManager;
        
        /**
         *
         * @var Cart $cartEntity
         */
        $cartEntity = $em->getRepository("Shop\Entity\Cart")->findOneBy(array(
            "user" => $this->userId,
            "isSettled" => FALSE
        ));
        
        $this->cartEntity = $cartEntity;
        return $this;
    }

    public function setCart($cartEntity = null)
    {
        if ($cartEntity == null) {
            $this->getCart();
            if ($this->cartEntity == Null) {
                
                $this->createCart();
            }
        } else {
            // var_dump("hyyyy");
            $this->cartEntity = $cartEntity;
        }
        
        return $this;
    }

    /**
     *
     * @return \Laminas\Session\Container
     */
    public function getCartItems()
    {
        if ($this->cartEntity != NULL) {
            return $this->cartEntity->getCartItems();
        } else {
            return [];
        }
    }

    public function getCartItemService()
    {
        // var
        $cartItemService = $this->cartItemService->setCart($this->cartEntity);
        return $cartItemService;
    }

    public function getCartDetails()
    {
        if ($this->cartEntity == null) {
            $this->setCart();
        }
        
        $cartItemService = $this->cartItemService->setCart($this->cartEntity);
        return $cartItemService->getCartDetails();
    }

    public function getfinalprice()
    {
        if ($this->cartEntity == null) {
            $this->setCart();
        }
        $cartItemService = $this->cartItemService->setCart($this->cartEntity);
        return $cartItemService->finalPrize();
    }

    /**
     * This creates a cart entity if it does not exist
     *
     * @return \Shop\Entity\Cart|unknown
     */
    public function createCart()
    {
        $em = $this->entityManager;
        
        $cartEntity = new Cart();
        $cartEntity->setCartUid($this->generateCartUid())
            ->setCreatedOn(new \DateTime())
            ->setIsSettled(FALSE)
            ->setUser($em->find(User::class, $this->userId));
        $em->persist($cartEntity);
        
        $this->unitOfWork = $em;
        $this->cartEntity = $cartEntity;
        
        return $this;
    }

    public function getCartCount()
    {
        $this->getCart();
        if ($this->cartEntity != NULL) {
            return count($this->cartEntity->getCartItems());
        } else {
            return 0;
        }
    }

    /**
     * This inserts a new product into the cart items session
     *
     * @param int $user            
     * @param int $product            
     * @param array $content            
     * @return string
     */
    public function insertItem(int $user, int $product, array $content)
    {
        $shoppingSession = $this->shoppingSession;
        $cartSession = $this->getCart();
        // $unserializedCart = unserialize($cartSession);
        
        // array_push($unserializedCart, $ray);
        // return serialize($unserializedCart);
    }

    /**
     * This function removes a particular item from the cart
     * It is fed with a specific item number to be removed from the list of items
     *
     * @param string $key            
     * @return boolean
     */
    public function removeItem(string $key)
    {
        $shopSession = $this->shoppingSession;
        // $cartSession = $shopSession["cart".$this->userId];
        $unserailizedCartItem = unserialize($shopSession["cart" . $this->userId]); // This is unserialized cart item
        unset($unserailizedCartItem[$key]);
        return true;
    }

    public function cartStructure()
    {}

    public function totalItems()
    {
        // FIXME -- finalize on this function
        $total_item = 0;
        // $uu =
        $this->getCart();
        
        $items = $this->cartEntity->getCartItems();
        return count($items);
    }

    public function removeAll()
    {}

    /**
     *
     * @return the $generalService
     */
    public function getGeneralService()
    {
        return $this->generalService;
    }

    /**
     *
     * @return the $entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     *
     * @return the $shoppingSession
     */
    public function getShoppingSession()
    {
        return $this->shoppingSession;
    }

    /**
     *
     * @return the $auth
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     *
     * @return the $userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     *
     * @param \General\Service\GeneralService $generalService            
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return $this;
    }

    /**
     *
     * @param \Doctrine\ORM\EntityManager $entityManager            
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     *
     * @param \Laminas\Session\Container $shoppingSession            
     */
    public function setShoppingSession($shoppingSession)
    {
        $this->shoppingSession = $shoppingSession;
        return $this;
    }

    /**
     *
     * @param \Laminas\Authentication\AuthenticationService $auth            
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
        return $this;
    }

    /**
     *
     * @param string $userId            
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     *
     * @param \Shop\Entity\CartItems $cartItemEntity            
     */
    public function setCartItemEntity($cartItemEntity)
    {
        $this->cartItemEntity = $cartItemEntity;
        return $this;
    }

    /**
     *
     * @param \Shop\Service\CartItemService $cartItemService            
     */
    public function setCartItemService($cartItemService)
    {
        $this->cartItemService = $cartItemService;
        return $this;
    }

    /**
     *
     * @return the $cartEntity
     */
    public function getCartEntity()
    {
        return $this->cartEntity;
    }
}

