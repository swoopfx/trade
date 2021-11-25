<?php
namespace Shop\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Shop\Service\CustomerService;

/**
 *
 * @author otaba
 *        
 */
class CustomerServiceFactory implements FactoryInterface
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
        
        $xserv = new CustomerService();
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $em = $generalService->getEntityManager();
        $xserv->setEntityManager($em);
        return $xserv;
    }
}

