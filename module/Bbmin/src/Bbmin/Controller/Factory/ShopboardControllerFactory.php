<?php
namespace Bbmin\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Bbmin\Controller\ShopboardController;

/**
 *
 * @author ezekiel
 *        
 */
class ShopboardControllerFactory implements FactoryInterface
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
        
         $ctr = new ShopboardController();
         $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
         
         return $ctr;
    }
}

