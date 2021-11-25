<?php
namespace Wallet\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Wallet\Service\CreditService;

/**
 *
 * @author otaba
 *        
 */
class CreditServiceFactory implements FactoryInterface
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
        
       $xserv = new CreditService();
       
       $generalService = $serviceLocator->get("General\Service\GeneralService");
       $em = $generalService->getEntityManager();
       $xserv->setEntityManager($em)->setGeneralService($generalService);
       return $xserv;
    }
}

