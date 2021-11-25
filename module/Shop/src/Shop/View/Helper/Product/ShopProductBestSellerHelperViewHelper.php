<?php
namespace Shop\View\Helper\Product;

use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author otaba
 *        
 */
class ShopProductBestSellerHelperViewHelper extends AbstractHelper implements ServiceLocatorAwareInterface
{
    
    private $serviceLocator;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function __invoke(){
        
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

