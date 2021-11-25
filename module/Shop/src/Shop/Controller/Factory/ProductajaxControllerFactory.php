<?php
namespace Shop\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Shop\Controller\ProductajaxController;

/**
 *
 * @author ezekiel
 *        
 */
class ProductajaxControllerFactory implements FactoryInterface
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
        $ctr = new ProductajaxController();
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $cartService = $serviceLocator->getServiceLocator()->get("Shop\Service\CartService");
        $ctr->setEntityManager($generalService->getEntityManager())
            ->setGeneralService($generalService)
            ->setCartService($cartService);
        return $ctr;
    }
}

