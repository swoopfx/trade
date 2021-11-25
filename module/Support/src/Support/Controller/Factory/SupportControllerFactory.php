<?php
namespace Support\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Support\Controller\SupportController;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class SupportControllerFactory implements FactoryInterface
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
        
        $ctr = new SupportController();
       /**
        * 
        * @var GeneralService $generalService
        */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $supportService = $serviceLocator->getServiceLocator()->get("Support\Service\SupportService");
        $ctr->setEntityManager($generalService->getEntityManager())->setSupportService($supportService);
        return $ctr;
    }
}

