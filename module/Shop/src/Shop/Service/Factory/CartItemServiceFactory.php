<?php
namespace Shop\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Shop\Service\CartItemService;

/**
 *
 * @author ezekiel
 *        
 */
class CartItemServiceFactory implements FactoryInterface
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
        
        $xserv = new CartItemService();
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $xserv->setEntityManager($generalService->getEntityManager())->setGeneralService($generalService);
        return $xserv;
        
    }
}

