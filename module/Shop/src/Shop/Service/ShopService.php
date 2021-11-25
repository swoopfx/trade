<?php
namespace Shop\Service;


/**
 *
 * @author otaba
 *        
 */
class ShopService
{
    const ORDER_DELIVERY_TYPE_HOME = 100;
    
    const ORDER_DELIVERY_TYPE_PICKUP = 10;
    
    const CHECKOUT_PAYMENT_TYPE_CARD = 10;
    
    const CHECKOUT_PAYMENT_TYPE_WALLET = 200;
    
    const CHECKOUT_PAYMENT_TYPE_CASH = 30;
    
    const CHECKOUT_PAYMENT_TYPE_BANK = 20;
    
    
    private $isHomeDelivery;
    
    /**
     * 
     * @var CartService
     */
    private $cartService;
    
   

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    public static function generateCategoryUid(){
        return uniqid(time());
    }
    
    
    public function finalCheckoutPrice(){
        
    }
    
    public function calculateDelivery(){
        
    }
    /**
     * @return the $isHomeDelivery
     */
    public function getIsHomeDelivery()
    {
        return $this->isHomeDelivery;
    }

    /**
     * @return the $cartService
     */
    public function getCartService()
    {
        return $this->cartService;
    }

    /**
     * @param field_type $isHomeDelivery
     */
    public function setIsHomeDelivery($isHomeDelivery)
    {
        $this->isHomeDelivery = $isHomeDelivery;
        return $this;
    }

    /**
     * @param \Shop\Service\CartService $cartService
     */
    public function setCartService($cartService)
    {
        $this->cartService = $cartService;
        return $this;
    }

}

