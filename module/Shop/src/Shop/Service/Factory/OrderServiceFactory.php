<?php
namespace Shop\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Shop\Service\OrderService;

/**
 *
 * @author otaba
 *        
 */
class OrderServiceFactory implements FactoryInterface
{

    /**
     */
    public function __construct()
    {}

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $xserve = new OrderService();
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $cartService = $serviceLocator->get("Shop\Service\CartService");
        $deliveryCalculatorService = $serviceLocator->get("Shop\Service\DeliveryCalculatorService");
        $transactionService = $serviceLocator->get('Transaction\Service\TransactionService');
        $xserve->setEntityManager($generalService->getEntityManager())
            ->setDeliverycalculatorService($deliveryCalculatorService)
            ->setGeneralService($generalService)
            ->setTransactionService($transactionService)
            ->setCartService($cartService);
        return $xserve;
    }
}

