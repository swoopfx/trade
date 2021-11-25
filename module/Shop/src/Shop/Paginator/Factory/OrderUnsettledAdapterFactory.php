<?php
namespace Shop\Paginator\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Shop\Paginator\OrderUnsettledAdapter;
use Laminas\Paginator\Paginator;

/**
 *
 * @author otaba
 *        
 */
class OrderUnsettledAdapterFactory implements FactoryInterface
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
        $adapter = new OrderUnsettledAdapter();
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $entityManager = $generalService->getEntityManager();
        $orderRepository = $entityManager->getRepository("Shop\Entity\CartOrders");
        $adapter->setRepository($orderRepository);
        
        $page = $serviceLocator->get("Application")
            ->getMvcEvent()
            ->getRouteMatch()
            ->getParam("page");
        $paginator = new Paginator($adapter);
        $paginator->setItemCountPerPage(20)->setCurrentPageNumber($page);
        return $paginator;
    }
}

