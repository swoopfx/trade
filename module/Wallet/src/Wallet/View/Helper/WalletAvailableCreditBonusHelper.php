<?php
namespace Wallet\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use General\Service\GeneralService;
use Wallet\Service\CreditService;

/**
 *
 * @author otaba
 *        
 */
class WalletAvailableCreditBonusHelper extends AbstractHelper implements ServiceLocatorAwareInterface
{
    
    private $serviceLocator;

   

    
    public function __invoke(){
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $this->getServiceLocator()->getServiceLocator()->get("General\Service\GeneralService");
        
        /**
         *
         * @var CreditService $creditService
         */
        $creditService = $this->getServiceLocator()->getServiceLocator()->get("Wallet\Service\CreditService");
        return $creditService->getCreditBonus($generalService->getUserId());
    }
    /**
     * {@inheritDoc}
     * @see \Laminas\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
     */
    public function setServiceLocator(\Laminas\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
        
    }

    /**
     * {@inheritDoc}
     * @see \Laminas\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
        
    }

    
   
   

}

