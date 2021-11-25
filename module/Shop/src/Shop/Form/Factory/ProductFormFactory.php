<?php
namespace Shop\Form\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Shop\Form\ProductForm;

/**
 *
 * @author otaba
 *        
 */
class ProductFormFactory implements FactoryInterface
{

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new ProductForm();
        return $form;
    }
}

