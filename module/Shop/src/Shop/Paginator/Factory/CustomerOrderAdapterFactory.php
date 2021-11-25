<?php
namespace Shop\Paginator\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
// use Bbmin\Paginator\CustomerAdapter;
use Shop\Paginator\CustomerOrderAdapter;
use Laminas\Paginator\Paginator;

/**
 *
 * @author ezekiel
 *        
 */
class CustomerOrderAdapterFactory implements FactoryInterface
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
        $adapter = new CustomerOrderAdapter();
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $entityManager = $generalService->getEntityManager();
        $userId = $generalService->getUserId();
        $orderRepository = $entityManager->getRepository("Shop\Entity\CartOrders");
        $adapter->setCartOrderRepository($orderRepository)->setUserId($userId);
        
        $page = $serviceLocator->get("Application")
            ->getMvcEvent()
            ->getRouteMatch()
            ->getParam("page");
        $paginator = new Paginator($adapter);
        $paginator->setItemCountPerPage(20)->setCurrentPageNumber($page);
        return $paginator;
    }
}

