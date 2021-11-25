<?php
namespace Transaction\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Transaction\Controller\TransactionController;
use General\Service\GeneralService;
use Shop\Service\OrderService;
use Transaction\Service\TransactionService;
use Shop\Service\CartService;
use Transaction\Service\InvoiceService;
use Application\Service\ApplicationService;

/**
 *
 * @author ezekiel
 *        
 */
class TransactionControllerFactory implements FactoryInterface
{

    // private
    
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
        $ctr = new TransactionController();
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        
        /**
         *
         * @var OrderService $orderService
         */
        $orderService = $serviceLocator->getServicelocator()->get("Shop\Service\OrderService");
        
        /**
         *
         * @var ProductService $productService
         */
        $productService = $serviceLocator->getServiceLocator()->get("Shop\Service\ProductService");
        
        /**
         *
         * @var InvoiceService $invoiceService
         */
        $invoiceService = $serviceLocator->getServiceLocator()->get("Transaction\Service\InvoiceService");
        
        /**
         *
         * @var CartService $cartService
         */
        $cartService = $serviceLocator->getServiceLocator()->get("Shop\Service\CartService");
        
        /**
         *
         * @var TransactionService $transactionService
         */
        $transactionService = $serviceLocator->getServiceLocator()->get("Transaction\Service\TransactionService");
        
        /**
         * 
         * @var ApplicationService $applicationService
         */
        $applicationService = $serviceLocator->getServiceLocator()->get("Application\Service\ApplicationService");
        
        $flutterwaveService = $serviceLocator->getServiceLocator()->get("Transaction\Service\FlutterwaveService");
        
        $ctr->setGeneralService($generalService)
            ->setEntityManager($generalService->getEntityManager())
            ->setOrderService($orderService)->setRenderer($generalService->getRenderer())
            ->setInvoiceService($invoiceService)
            ->setCartService($cartService)
            ->setAppService($applicationService)
            ->setFlutterwaveService($flutterwaveService)
            ->setTransactionService($transactionService);
        return $ctr;
    }
}

