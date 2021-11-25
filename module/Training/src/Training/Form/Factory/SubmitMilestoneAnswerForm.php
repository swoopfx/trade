<?php
namespace Training\Form\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Training\Form\SubmiMilestoneAnswerForm;

/**
 *
 * @author mac
 *        
 */
class SubmitMilestoneAnswerForm implements FactoryInterface
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
        
        $form = new SubmiMilestoneAnswerForm();
        return $form;
    }
    
    
   
}

