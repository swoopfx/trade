<?php
namespace Shop\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Shop\Service\CartService;

/**
 *
 * @author otaba
 *        
 */
class CartServiceFactory implements FactoryInterface
{

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $xserv = new CartService();
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $cartItemService = $serviceLocator->get('Shop\Service\CartItemService');
        $xserv->setGeneralService($generalService)
            ->setAuth($generalService->getAuth())
            ->setCartItemService($cartItemService)
            ->setEntityManager($generalService->getEntityManager())
            ->setShoppingSession($generalService->getShopppingSession())
            ->setUserId($generalService->getUserId());
            $shopSession = $generalService->getShopppingSession();
//             $shopSession[$generalService->getUserId()] = array();
//             $shopSession["cart".$generalService->getUserId()] = array(
//                 [
//                     "power"=>"Kill",
//                     "please"=>1,
//                     "Kent"=>"GTTT"
//                 ],
//                 [
//                     "power"=>"Kola"
//                 ],
//                 [
//                     "power"=>"Kunle"
//                 ]
//             );
//             var_dump( $shopSession["cart".$generalService->getUserId()]);
           
//             $cart
//                         array_push( $shopSession["cart".$generalService->getUserId()], array(
//                             "killing"=>"KIUUUL"
//                         ));
//                         var_dump( $shopSession["cart".$generalService->getUserId()]);
            
//             $ray = 
//             var_dump($generalService->getUserId());
//             var_dump($shopSession[$generalService->getUserId()]);
            
            
        return $xserv;
    }
}

