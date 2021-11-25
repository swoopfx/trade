<?php
namespace Wallet\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Wallet\Controller\WalletController;

class WalletControllerFactory implements FactoryInterface
{

    public function __construct()
    {

        
    }

    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        /**
         *
         * @var \Wallet\Controller\WalletController $ctr
         */
        $ctr = new WalletController();
        /**
         * 
         * @var \General\Service\GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General/Service/GeneralService");
        $em = $generalService->getEntityManager();
        
        $ctr->setEntityManager($em)->setRenderer($generalService->getRenderer());
        return $ctr;
    }
}

