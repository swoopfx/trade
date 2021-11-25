<?php
namespace Bbmin\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Bbmin\Controller\WalletController;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class WalletControllerFactory implements FactoryInterface
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
        
       $ctr = new WalletController();
       
       /**
        * 
        * @var GeneralService $generalService
        */
       $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
       $walletPaginator = $serviceLocator->getServicelocator()->get("Wallet\Paginator\WalletAdapter");
       $ctr->setWalletPaginator($walletPaginator);



       $ctr->setEntityManager($generalService->getEntityManager());
       return $ctr;
    }
}

