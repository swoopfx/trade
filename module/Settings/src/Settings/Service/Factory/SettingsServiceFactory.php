<?php
namespace Settings\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Settings\Service\SettingsService;

/**
 *
 * @author otaba
 *        
 */
class SettingsServiceFactory implements FactoryInterface
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
        $xserv = new SettingsService();
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $xserv->setEntityManager($generalService->getEntityManager())
            ->setGeneralService($generalService);
        return $xserv;
    }
}

