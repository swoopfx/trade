<?php
namespace Transaction\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Transaction\Service\TransactionService;

/**
 *
 * @author otaba
 *        
 */
class TransactionServiceFactory implements FactoryInterface
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
        $xserv = new TransactionService();
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $config = $serviceLocator->get('config');
        $flutterwaveConfig = (getenv('APPLICATION_ENV') == "development" ? $config["flutterwave"]["dev"] : $config['flutterwave']['live']);
        $xserv->setGeneralService($generalService)
            ->setEntityManager($generalService->getEntityManager())
            ->setUserId($generalService->getUserId());
        return $xserv;
    }
}

