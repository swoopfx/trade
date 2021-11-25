<?php
namespace Bbmin\Paginator\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Bbmin\Paginator\CustomerAdapter;
use Laminas\Paginator\Paginator;

/**
 *
 * @author otaba
 *        
 */
class CustomerAdapterFactoryInterface implements FactoryInterface
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
        
        $adapter = new CustomerAdapter();
        
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $entityManager = $generalService->getEntityManager();
        $customerRepository = $entityManager->getRepository("CsnUser\Entity\User");
        $adapter->setRepository($customerRepository);
        
        $page = $serviceLocator->get("Application")->getMvcEvent()->getRouteMatch()->getParam("page");
        
        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(1);
        
        return $paginator;
    }
}

