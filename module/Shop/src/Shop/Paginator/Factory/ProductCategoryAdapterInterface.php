<?php
namespace Shop\Paginator\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Shop\Paginator\ProductCategoryAdapter;
use Laminas\Paginator\Paginator;
use Shop\Entity\Product;

/**
 *
 * @author otaba
 *        
 */
class ProductCategoryAdapterInterface implements FactoryInterface
{

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
       
        $adapter = new ProductCategoryAdapter();
        
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        
        $entityManager = $generalService->getEntityManager();
        $productRepository = $entityManager->getRepository(Product::class);
        $adapter->setRepository($productRepository);
//         var_dump($productRepository);
        $catId = $serviceLocator->get("Application")
            ->getMvcEvent()
            ->getRouteMatch()
            ->getParam("category");
//             var_dump("KKKKK");
        
        $page = $serviceLocator->get("Application")
            ->getMvcEvent()
            ->getRouteMatch()
            ->getParam("page");
        
        $adapter->setCatId($catId);
        $paginator = new Paginator($adapter);
//         var_dump($paginator);
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(2);
//         var_dump($catId);
        return $paginator;
    }
}

