<?php
namespace Shop\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Shop\Service\DeliveryCalculatorService;

/**
 *
 * @author ezekiel
 *        
 */
class DeliveryCalculatorServiceFactory implements FactoryInterface
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
        $xserv = new DeliveryCalculatorService();
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $cartService = $serviceLocator->get('Shop\Service\CartService');
        $appService = $serviceLocator->get('Application\Service\ApplicationService');
        // $cartEntity = $cartService->getCart()->getCartEntity();->set
        
        $xserv->setGeneralService($generalService)
            ->setEntityManager($generalService->getEntityManager())
            ->setAppService($appService)
            ->setCartService($cartService);
        return $xserv;
    }
}

