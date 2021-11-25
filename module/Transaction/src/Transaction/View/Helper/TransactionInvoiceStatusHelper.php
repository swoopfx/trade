<?php
namespace Transaction\View\Helper;

use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Transaction\Service\InvoiceService;

/**
 *
 * @author ezekiel
 *        
 */
class TransactionInvoiceStatusHelper extends AbstractHelper implements ServiceLocatorAwareInterface
{
    
    private $servicelocator;

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
        
        return $this->servicelocator;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
     *
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        
        $this->servicelocator = $serviceLocator;
        return $this;
    }

    

    public function __invoke($data){
//        $frame = "";
       if($data == InvoiceService::INVOICE_STATUS_PAID){
           return "<span class='square-8 bg-success mg-r-5 rounded-circle'></span> PAID";
       }else if($data == InvoiceService::INVOICE_STATUS_INITIATED){
           return "<span class='square-8 bg-warning mg-r-5 rounded-circle'></span> INITIATED";
       }elseif (InvoiceService::INVOICE_STATUS_PART_PAYMENT){
           return "<span class='square-8 bg-warning mg-r-5 rounded-circle'></span> PART PAYMENT";
       }else{
           return "<span class='square-8 bg-danger mg-r-5 rounded-circle'></span> CANCELED";
       }
    }
    
}

