<?php
namespace Shop\Form\Fieldset\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Shop\Form\Fieldset\ProductCategoryFieldset;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class ProductCategoryFieldsetFactory implements FactoryInterface
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
        
       $fieldset = new ProductCategoryFieldset();
       /**
        *
        * @var GeneralService $generalService
        */
       $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
       $fieldset->setEntityManager($generalService->getEntityManager());
       return $fieldset;
    }
}

