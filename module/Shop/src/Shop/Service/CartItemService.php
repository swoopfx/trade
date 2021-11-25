<?php
namespace Shop\Service;

use Doctrine\ORM\EntityManager;
use General\Service\GeneralService;
use Shop\Entity\CartItems;
use Shop\Entity\Cart;
use Doctrine\ORM\Query;
use Doctrine\Common\Collections\Collection;

/**
 *
 * @author ezekiel
 *        
 */
class CartItemService
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     * 
     * @var array
     */
    private $cartItems;

    private $cartItem; // cart item prepared for indivual removal or edit
    
    private $item = [];

    private $cartItemToken;

    private $cartItemProduct;

    private $cartItemContent;
    
    
    private $cartContentDetails;

    /**
     * 
     * @var Cart
     */
    private $cart;

    private $itemTotalQuantity;

    private $itemActivePrice;
    
    
    private $finalPrice;
    
    private $unitOfWork;

    const ITEM_QUANTITY_NAME = "quant";
    
    const ITEM_PRICE_NAME = 'price';
    
    const ITEM_TOTAL_PRICE_NAME = 'totalPrice';
    
    const ITEM_CART_CONTENT_DETAIL = 'contentdetails';
    
    const PRODUCT_PRICE ='product_price';
    
    

    // TODO - Insert your code here
    private function generateToken()
    {
        return uniqid(rand());
    }
    
    
    public function execute(){
        $this->unitOfWork->flush();
    }

    /**
     */
    public function __construct()
    {
        
        
    }

//     public function getCartItems()
//     {
//         $em = $this->entityManager;
//         $data = $em->getRepository(CartItems::class)
//             ->createQueryBuilder('i')
//             ->select([
//             'i',
//             'p',
//             'c'
//         ])
//             ->leftJoin('i.product', 'p')
//             ->leftJoin('i.cart', 'c')
//             ->where('c.id = :cart')
//             ->setParameters([
//                 'cart'=>$this->cart->getId()
//             ])
//             ->getQuery()
//             ->getResult(Query::HYDRATE_ARRAY);
            
//             foreach ($data as $item){
                
//             }

        
//     }

    public function getCartDetails(){
        $cartItems = $this->cart->getCartItems();
        $cartDetails = [];
//        var_dump('juu');
        foreach ($cartItems as $x=>$item){
            $this->totalItemQuantity($item)->itemActivePrice($item);
           $cartDetails[$x][self::ITEM_QUANTITY_NAME]=$this->itemTotalQuantity; // this is the sum of all the product in the 
           $cartDetails[$x][self::PRODUCT_PRICE] = $item->getProduct()->getPrice(); // price of the product 
           $cartDetails[$x][self::ITEM_CART_CONTENT_DETAIL] = $this->cartContentDetails; // details of the cart 
           $cartDetails[$x][self::ITEM_PRICE_NAME] = $this->itemActivePrice;
           $cartDetails[$x][self::ITEM_TOTAL_PRICE_NAME]=$this->itemTotalPrice($item);
           $cartDetails[$x]['cartItemId'] = $item->getId();
           $cartDetails[$x]['product_name'] = $item->getProduct()->getProductDescription()->getProductName();
           $cartDetails[$x]['product_uid'] = $item->getProduct()->getProductUid();
           $cartDetails[$x]['product_id'] = $item->getProduct()->getId();
           $cartDetails[$x]['sku'] = $item->getProduct()->getSku();
           $cartDetails[$x]['product_image'] = $item->getProduct()->getImage()[0]->getImageUrl();
           
        }
//         $cartDetails['finaPrice']= $this->finalPrize();
        return $cartDetails;
    }
    
    

    public function insertItem()
    {
        $em = $this->entityManager;
        
        $cartItem = new CartItems();
       
        $cartContent = serialize($this->cartItemContent);
        $cartItem->setCartContent($cartContent)
            ->setCreatedOn(new \DateTime())
            ->setProduct($this->cartItemProduct)
            ->setCart($this->cart)
            ->setToken($this->generateToken());
        
        $em->persist($cartItem);
        
        $this->unitOfWork = $em;
        return $this;
        
    }
    
    public function removeItem(){
        $em = $this->entityManager;
        $item = $em->find(CartItems::class, $this->cartItem);
        $em->remove($item);
        $this->unitOfWork = $em;
        return $this;
    }

    /**
     *
     * @param CartItems $item            
     * @return \Shop\Service\CartItemService
     */
    public function totalItemQuantity($item)
    {
        $unserializedContent = unserialize($item->getCartContent());
        $itemQuantity = 0;
        
        $this->cartContentDetails = $unserializedContent;
        foreach ($unserializedContent as $content) {
            $itemQuantity += $content->quant;
        }
        $this->itemTotalQuantity = $itemQuantity;
        
        return $this;
    }
    
    
    public static function itemTotalQuantity($item){
        $unserializedContent = unserialize($item->getCartContent());
        $itemQuantity = 0;
        
        
        foreach ($unserializedContent as $content) {
            $itemQuantity += $content->quant;
        }
       return  $itemQuantity;
    }

    /**
     *
     * @param CartItems $item            
     * @return \Shop\Service\CartItemService
     */
    public function itemActivePrice($item)
    {
        $this->totalItemQuantity($item);
        if ($item->getProduct()->getIsDiscount()) {
            if ($this->itemTotalQuantity >= $item->getProduct()
                ->getDiscount()
                ->getQuantity()) {
                $this->itemActivePrice = $item->getProduct()
                    ->getDiscount()
                    ->getPrice();
            } else {
                $this->itemActivePrice = $item->getProduct()->getPrice();
            }
        } else {
            $this->itemActivePrice = $item->getProduct()->getPrice();
        }
        
        return $this;
    }

    /**
     *
     * @param CartItems $item            
     * @return number
     */
    public function itemTotalPrice($item)
    {
        $this->itemActivePrice($item);
        return $this->itemActivePrice * $this->itemTotalQuantity;
    }

    /**
     *
     * @return number
     */
    public function finalPrize()
    {
        $finalPrice = 0;
        $cartItems = $this->cart->getCartItems();
        foreach ($cartItems as $carItem) {
            $finalPrice += $this->itemTotalPrice($carItem);
        }
        $this->finalPrice = $finalPrice;
        return $finalPrice;
    }
    
    public function vatprice(){
        $this->finalPrice();
        return $this->finalPrice;
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
     * @return the $generalService
     */
    public function getGeneralService()
    {
        return $this->generalService;
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
     * @param \General\Service\GeneralService $generalService            
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return $this;
    }
    /**
     * @param field_type $cartItems
     */
    public function setCartItems($cartItems)
    {
        $this->cartItems = $cartItems;
        return $this;
    }

    /**
     * @param multitype: $item
     */
    public function setItem($item)
    {
        $this->item = $item;
        return $this;
    }

    /**
     * @param field_type $cartItemToken
     */
    public function setCartItemToken($cartItemToken)
    {
        $this->cartItemToken = $cartItemToken;
        return $this;
    }

    /**
     * @param field_type $cartItemProduct
     */
    public function setCartItemProduct($cartItemProduct)
    {
        $this->cartItemProduct = $cartItemProduct;
        return $this;
    }

    /**
     * @param field_type $cartItemContent
     */
    public function setCartItemContent($cartItemContent)
    {
        $this->cartItemContent = $cartItemContent;
        return $this;
    }

    /**
     * @param field_type $cart
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
        return $this;
    }
    
    public function setCartItem( $cartItem){
        $this->cartItem = $cartItem;
        return $this;
    }

    /**
     * @param Ambigous <number, mixed> $itemTotalQuantity
     */
    public function setItemTotalQuantity($itemTotalQuantity)
    {
        $this->itemTotalQuantity = $itemTotalQuantity;
        return $this;
    }

    /**
     * @param field_type $itemActivePrice
     */
    public function setItemActivePrice($itemActivePrice)
    {
        $this->itemActivePrice = $itemActivePrice;
        return $this;
    }
    /**
     * @return the $itemTotalQuantity
     */
    public function getItemTotalQuantity()
    {
        return $this->itemTotalQuantity;
    }


}

