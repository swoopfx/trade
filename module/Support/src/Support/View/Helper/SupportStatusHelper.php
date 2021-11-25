<?php
namespace Support\View\Helper;

use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Support\Service\SupportService;

/**
 * This class handles how the support status is presented
 * @author otaba
 *        
 */
class SupportStatusHelper extends AbstractHelper implements ServiceLocatorAwareInterface
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

    public function __invoke($status){
         switch ($status){
             case SupportService::SUPPORT_STATUS_INITIATED:
                 return "<span class='square-8 bg-danger mg-r-5 rounded-circle.></span> INITIATED";
                 break;
                 
             case SupportService::SUPPORT_STATUS_CLOSED:
                 return "<span class='square-8 bg-success mg-r-5 rounded-circle.></span> CLOSED";
                 break;
                 
             case SupportService::SUPPORT_STATUS_PROCESSING:
                 return "<span class='square-8 bg-warning mg-r-5 rounded-circle.></span> PROCESSING";
                 break;
         }
    }
}

