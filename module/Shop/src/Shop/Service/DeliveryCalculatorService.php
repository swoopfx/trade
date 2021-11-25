<?php
namespace Shop\Service;

use Doctrine\ORM\EntityManager;
use General\Service\GeneralService;
use Shop\Entity\Cart;
use Application\Service\ApplicationService;
use User\Entity\UserProfile;

/**
 *
 * @author ezekiel
 *        
 */
class DeliveryCalculatorService
{
    const BIKE_MAXIMUM_WEIGTH = 5; //in kilograms
    
    const PRICE_PER_WEIGTH = 400;

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
     * @var integer
     */
    private $deliveryPrice = 1500;

    /**
     *
     * @var Cart
     */
    private $cartEntity;

    /**
     *
     * @var CartService
     */
    private $cartService;
    
    /**
     * 
     * @var ApplicationService
     */
    private $appService;

    // private $user
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    private function calculateCartWeigth()
    {
//         $cart = $this->cart;
        // $price = $this->deliveryPrice;
        
        $cartService = $this->cartService;
        $cartEntiy = $cartService->setCart()->getCartEntity();
        $totalQuantity = 0;
        $totalWeith = 0;
        // $cartService->getCartItemService()->
        foreach ($cartEntiy as $x => $item) {
            $totalQuantity = $this->cartService->setCart()
                ->getCartItemService()
                ->totalItemQuantity($item)
                ->getItemTotalQuantity();
                $productWeigth = $item[$x]->getWeight() == null ? 1 : $item[$x]->getWeight();
                $totalWeith = $productWeigth * $totalQuantity;
        }
        return $totalWeith;
    }

    /**
     * 
     */
    private function getuserLocation()
    {
        $user = $this->generalService->getUserEntity();
        /**
         * 
         * @var UserProfile $userProfile
         */
        $userProfile = $this->appService->getUserProfile();
        return $userProfile->getState()->getName();
    }
    
    
    public function delivery(){
        
        $stateLocation = $this->getuserLocation();
        
//         if($stateLocation != )
        $cartWeigth = $this->calculateCartWeigth();
        
        if( $cartWeigth <= self::BIKE_MAXIMUM_WEIGTH){
            return $this->deliveryPrice;
        }else if($cartWeigth > self::BIKE_MAXIMUM_WEIGTH){
            return $cartWeigth * self::PRICE_PER_WEIGTH;
        }else{
            return $this->deliveryPrice;
        }
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
     * @return the $deliveryPrice
     */
    public function getDeliveryPrice()
    {
        return $this->deliveryPrice;
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
     *
     * @param number $deliveryPrice            
     */
    public function setDeliveryPrice($deliveryPrice)
    {
        $this->deliveryPrice = $deliveryPrice;
        return $this;
    }

    /**
     *
     * @return the $cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     *
     * @param \Shop\Entity\Cart $cart            
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
        return $this;
    }

    /**
     *
     * @return the $cartService
     */
    public function getCartService()
    {
        return $this->cartService;
    }

    /**
     *
     * @param \Shop\Service\CartService $cartService            
     */
    public function setCartService($cartService)
    {
        $this->cartService = $cartService;
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

    /**
     *
     * @param \Shop\Entity\Cart $cartEntity            
     */
    public function setCartEntity($cartEntity)
    {
        $this->cartEntity = $cartEntity;
        return $this;
    }
    /**
     * @param \Application\Service\ApplicationService $appService
     */
    public function setAppService($appService)
    {
        $this->appService = $appService;
        return $this;
    }

}

