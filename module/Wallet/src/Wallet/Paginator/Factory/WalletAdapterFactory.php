<?php
namespace Wallet\Paginator\Factory;

use Laminas\Paginator\Paginator;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Wallet\Paginator\WalletAdapter;

/**
 *
 * @author otaba
 *        
 */
class WalletAdapterFactory implements FactoryInterface
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
        
        $adapter = new WalletAdapter();
        /**
         * 
         * @var \General\Service\GeneralService $generalService
         */
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $entityManager = $generalService->getEntityManager();

        $walletRepository = $entityManager->getRepository("Wallet\Entity\Wallet");
        $adapter->setRepository($walletRepository);

        $page = $serviceLocator->get("Application")->getMvcEvent()->getRouteMatch()->getParam("page");

        $paginator = new Paginator($adapter);
        $paginator->setItemCountPerPage(30)->setCurrentPageNumber($page);
        return $paginator;
        
    }
}

