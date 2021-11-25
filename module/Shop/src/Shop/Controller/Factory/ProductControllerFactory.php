<?php
namespace Shop\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Shop\Controller\ProductController;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class ProductControllerFactory implements FactoryInterface
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
        $ctr = new ProductController();
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServicelocator()->get("General\Service\GeneralService");
        $productService = $serviceLocator->getServiceLocator()->get("Shop\Service\ProductService");
        $userProduct = $serviceLocator->getServiceLocator()->get("Shop\Paginator\ProductConsumerAdapter");
        $ctr->setEntityManager($generalService->getEntityManager())
            ->setGeneralService($generalService)
            ->setProductAdapter($userProduct)
            ->setProductService($productService);
        return $ctr;
    }
}

