<?php
namespace Wallet\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Wallet\Service\WalletService;
use Laminas\Session\Container;

class WalletServiceFactory implements FactoryInterface
{

    public function __construct()
    {

        // TODO - Insert your code here
    }

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $xserv = new WalletService();
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $creditService = $serviceLocator->get("Wallet\Service\CreditService");
        $transactionService = $serviceLocator->get("Transaction\Service\TransactionService");
        $referalService = $serviceLocator->get("Wallet\Service\ReferalService");
        $walletSession = new Container("wallet_session");
        $em = $generalService->getEntityManager();
        $xserv->setGeneralService($generalService)
            ->setEntityManager($em)
            ->setCreditService($creditService)
            ->setTransactionService($transactionService)
            ->setReferalService($referalService)
            ->setUserId($generalService->getUserId())
            ->setWalletSession($walletSession);
        return $xserv;
    }
}

