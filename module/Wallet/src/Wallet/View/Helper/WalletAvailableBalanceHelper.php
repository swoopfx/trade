<?php
namespace Wallet\View\Helper;

use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Wallet\Service\WalletService;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class WalletAvailableBalanceHelper extends AbstractHelper implements ServiceLocatorAwareInterface
{
    
    private $serviceLocator;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
     *
     */
    public function getServiceLocator()
    {
        
        return $this->serviceLocator;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
     *
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        
         $this->serviceLocator = $serviceLocator;
        return $this;
    }

    public function __invoke(){
        /**
         * 
         * @var GeneralService $generalService
         */
        $generalService = $this->getServiceLocator()->getServiceLocator()->get("General\Service\GeneralService");
        /**
         * 
         * @var WalletService $walletService
         */
        $walletService = $this->getServiceLocator()->getServiceLocator()->get("Wallet\Service\WalletService");
        
        $balance = $walletService->getAvaialableBalance($generalService->getUserId());
        return $balance;
    }
}

