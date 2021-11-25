<?php
namespace Support\Form\Fieldset\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Support\Form\Fieldset\SupportWYSIWYGFieldset;

/**
 *
 * @author otaba
 *        
 */
class SupportWYSIWYGFieldsetFactory implements FactoryInterface
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
        
        $fieldset= new SupportWYSIWYGFieldset();
        return $fieldset;
    }
}

