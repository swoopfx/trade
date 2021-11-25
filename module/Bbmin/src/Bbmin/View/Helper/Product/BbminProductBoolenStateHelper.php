<?php
namespace Bbmin\View\Helper\Product;

use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;

class BbminProductBoolenStateHelper extends  AbstractHelper implements ServiceLocatorAwareInterface
{
    
    private $serviceLocator;
    
    public function __invoke($data){
        
        if($data == TRUE){
            return "<span class='label label-green'>TRUE</span>";
        }else{
            return  "<span class='label label-red'>FALSE</span>";
        }
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
        return  $this->serviceLocator;
        
    }

}

