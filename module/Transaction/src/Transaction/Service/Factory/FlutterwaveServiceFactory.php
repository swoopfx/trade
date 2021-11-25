<?php
namespace Transaction\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Transaction\Service\FlutterwaveService;
use Laminas\Session\Container;

/**
 *
 * @author mac
 *        
 */
class FlutterwaveServiceFactory implements FactoryInterface
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
        
        $flutterSession = new Container("flutter_session");
        $config = $serviceLocator->get('config');
        $flutterwaveConfig = (getenv('APPLICATION_ENV') == "development" ? $config["flutterwave"]["dev"] : $config['flutterwave']['live']);
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $xserv = new FlutterwaveService();
        $xserv->setFlutterwaveConfig($flutterwaveConfig);
        return $xserv;
    }
}

