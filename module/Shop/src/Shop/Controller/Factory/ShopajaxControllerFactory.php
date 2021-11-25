<?php
namespace Shop\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Shop\Controller\ShopajaxController;
use General\Service\GeneralService;
use Shop\Service\ProductService;
use Application\Service\ApplicationService;

/**
 *
 * @author otaba
 *        
 */
class ShopajaxControllerFactory implements FactoryInterface
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
        $ctr = new ShopajaxController();
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        /**
         * 
         * @var ProductService $productService
         */
        $productService = $serviceLocator->getServiceLocator()->get("Shop\Service\ProductService");
        
        $orderService = $serviceLocator->getServiceLocator()->get("Shop\Service\OrderService");
        $invoiceService = $serviceLocator->getServiceLocator()->get("Transaction\Service\InvoiceService");
        /**
         * 
         * @var ApplicationService $applicationService
         */
        $applicationService = $serviceLocator->getServiceLocator()->get("Application\Service\ApplicationService");
        $cartService = $serviceLocator->getServiceLocator()->get("Shop\Service\CartService");
        $deliveryCalculatorService =$serviceLocator->getServiceLocator()->get("Shop\Service\DeliveryCalculatorService");
        $ctr->setEntityManager($generalService->getEntityManager())
            ->setRenderer($generalService->getRenderer())
            ->setProducService($productService)
            ->setApplicationService($applicationService)
            ->setCartService($cartService)
            ->setDeliveryCalculatorService($deliveryCalculatorService)
            ->setOrderService($orderService)
            ->setInvoiceService($invoiceService)
            ->setGeneralService($generalService);
        return $ctr;
    }
}

