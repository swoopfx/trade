<?php
namespace Transaction\View\Helper;

use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Transaction\Service\TransactionService;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class TransactionBonusHelper extends AbstractHelper implements ServiceLocatorAwareInterface
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
        
        $this->serviceLocator= $serviceLocator;
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
         * @var TransactionService $transactionService
         */
        $transactionService = $this->getServiceLocator()->getServiceLocator()->get("Transaction\Service\TransactionService");
        return $transactionService->getTransactionBonus($generalService->getUserId());
    }
}

