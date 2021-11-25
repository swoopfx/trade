<?php
namespace Bbmin\Paginator\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Bbmin\Paginator\CustomerBlacklistAdapter;

/**
 *
 * @author otaba
 *        
 */
class CustomerBlacklistAdapterFactory implements FactoryInterface
{

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        
        $adapter = new CustomerBlacklistAdapter;
    }
}

