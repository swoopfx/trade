<?php
namespace Bbmin\Paginator\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Bbmin\Paginator\OrderAdminPaginator;
use Laminas\Paginator\Paginator;
use Shop\Entity\CartOrders;

/**
 *
 * @author mac
 *        
 */
class OrderAdminPaginatorFactory implements FactoryInterface
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
        
        $adapter = new OrderAdminPaginator();
        
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $entityManager = $generalService->getEntityManager();
        $orderRepository = $entityManager->getRepository(CartOrders::class);
        $adapter->setOrderRepository($orderRepository);
        
        $page = $serviceLocator->get("Application")
        ->getMvcEvent()
        ->getRouteMatch()
        ->getParam("page");
        $paginator = new Paginator($adapter);
        //         var_dump($paginator);
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(50);
        //         var_dump($paginator);
        return $paginator;
    }
}

