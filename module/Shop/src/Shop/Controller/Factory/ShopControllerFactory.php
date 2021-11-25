<?php
namespace Shop\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Shop\Controller\ShopController;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class ShopControllerFactory implements FactoryInterface
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
        $ctr = new ShopController();
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $categoryPaginator = $serviceLocator->getServiceLocator()->get("Shop\Paginator\ProductCategoryAdapter");
        $ctr->setEntityManager($generalService->getEntityManager())
            ->setProductCategoryPagination($categoryPaginator);
        return $ctr;
    }
}

