<?php
namespace Training\Form\Fieldset\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Interop\Container\ContainerInterface;
use Training\Form\Fieldset\SubmitMilestoneAnswerFieldset;

/**
 *
 * @author mac
 *        
 */
class SubmitMilestoneAnswerFieldsetFactory implements FactoryInterface
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
       
        $fieldset = new SubmitMilestoneAnswerFieldset();
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
       
        $em = $generalService->getEntityManager();
        $fieldset->setEntityManager($em);
        return $fieldset;
    }
    
   
}

