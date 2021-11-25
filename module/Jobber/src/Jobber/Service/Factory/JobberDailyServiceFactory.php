<?php
namespace Jobber\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Jobber\Service\JobberDailyService;

/**
 *
 * @author otaba
 *        
 */
class JobberDailyServiceFactory implements FactoryInterface
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
        
       $xserv = new JobberDailyService();
       /**
        * 
        * @var \General\Service\GeneralService $generalService
        */
       $generalService = $serviceLocator->get("General\Service\GeneralService");
       $xserv->setEntityManager($generalService->getEntityManager());
       return $xserv;
    }
}

