<?php
namespace Training\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Training\Service\YoutubeApiService;

/**
 *
 * @author mac
 *        
 */
class YoutubeApiServiceFactory implements FactoryInterface
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
        
        $xserv = new YoutubeApiService();
        $config = $serviceLocator->get("Config");
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        
        $api_key = $config["google"]["api_key"];
        $xserv->setGoogleApi($api_key)->setEntityManager($generalService->getEntityManager());
        return $xserv;
    }
}

