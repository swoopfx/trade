<?php
namespace Wallet\View\Helper;

use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Wallet\Service\ReferalService;

/**
 *
 * @author otaba
 *        
 */
class WalletReferalBonusHelper extends AbstractHelper implements ServiceLocatorAwareInterface
{
    
    private $serviceLocator;

    

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
         * @var ReferalService $referalService
         */
        $referalService = $this->getServiceLocator()->getServiceLocator()->get("Wallet\Service\ReferalService");
        return $referalService->getReferalUnits();
    }
}

