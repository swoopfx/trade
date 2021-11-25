<?php
namespace Shop\Paginator\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Shop\Paginator\ProductAdapter;
use Laminas\Paginator\Paginator;

/**
 *
 * @author otaba
 *        
 */
class ProductAdapterInterface implements FactoryInterface
{

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $adapter = new ProductAdapter();
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $entityManager = $generalService->getEntityManager();
        $productRepository = $entityManager->getRepository("Shop\Entity\Product");
        $adapter->setRepository($productRepository);
        
        $page = $serviceLocator->get("Application")
            ->getMvcEvent()
            ->getRouteMatch()
            ->getParam("page");
        
        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(20);
        return $paginator;
    }
}

