<?php
namespace Support\Form\Fieldset\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Support\Form\Fieldset\SupportFieldset;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class SupportFieldsetFactory implements FactoryInterface
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
        
        $fieldset = new SupportFieldset();
        /**
         * 
         * @var GeneralService $generalService
         */
        
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $fieldset->setEntityManager($generalService->getEntityManager());
        
        return $fieldset;
    }
}

