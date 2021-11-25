<?php
namespace Application\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Application\Service\ApplicationService;

/**
 *
 * @author otaba
 *        
 */
class ApplicationServiceFactory implements FactoryInterface
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
        $xserv = new ApplicationService();
        /**
         *
         * @var \General\Service\GeneralService $generalService
         */
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        
        $xserv->setAuth($generalService->getAuth())
            ->setEntityManager($generalService->getEntityManager())
            ->setGeneralService($generalService)
            ->setUserId($generalService->getUserId());
        
        return $xserv;
    }
}

