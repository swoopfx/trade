<?php
namespace Bbmin\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Bbmin\Controller\SalesController;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class SalesControllerFactory implements FactoryInterface
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
        $ctr = new SalesController();
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $orderPaginator = $serviceLocator->getServiceLocator()->get("Bbmin\Paginator\OrderAdminPaginator");
        $cartService = $serviceLocator->getServiceLocator()->get("Shop\Service\CartService");
        $em = $generalService->getEntityManager();
        $ctr->setOrderpaginator($orderPaginator)
            ->setEntityManager($generalService->getEntityManager())
            ->setCartService($cartService);
        return $ctr;
    }
}

