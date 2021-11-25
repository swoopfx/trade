<?php
namespace Shop\Form\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Shop\Form\ShopHomeSplashForm;

/**
 *
 * @author otaba
 *        
 */
class ShopHomeSplashFormFactory implements FactoryInterface
{

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new ShopHomeSplashForm();
        return $form;
    }
}

