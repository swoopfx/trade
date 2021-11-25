<?php
namespace General\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use General\Controller\GeneralController;

/**
 *
 * @author mac
 *        
 */
class GeneralControllerFactory implements FactoryInterface
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
        $ctr = new GeneralController();
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        return $ctr;
    }
}

