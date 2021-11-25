<?php
namespace Training\Form\Fieldset\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Training\Form\Fieldset\ProgrammeFieldset;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class ProgrammesFieldsetFactory implements FactoryInterface
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
        
        $fieldset = new ProgrammeFieldset();
        /**
         * 
         * @var GeneralService $generalSerive
         */
        $generalSerive = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $fieldset->setEntityManager($generalSerive->getEntityManager());
        return $fieldset;
    }
}

