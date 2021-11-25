<?php
namespace Wallet\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Wallet\Controller\WalletasyncController;

class WalletasyncControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $ctr = new WalletasyncController();
        /**
         *
         * @var \General\Service\GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General/Service/GeneralService");
        $em = $generalService->getEntityManager();
        $ctr->setEntityManager($em)->setGeneralService($generalService);
        return $ctr;
    }
}

