<?php
namespace General\Paginator\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use General\Paginator\Adapter;

/**
 *
 * @author otaba
 *        
 */
class AdapterFactory implements FactoryInterface
{

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
//         $adapter = new Adapter($repository)
    }
}

