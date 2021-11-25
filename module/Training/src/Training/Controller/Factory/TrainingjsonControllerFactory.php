<?php
namespace Training\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Training\Controller\TrainingjsonController;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class TrainingjsonControllerFactory implements FactoryInterface
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
        $ctr = new TrainingjsonController();
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $trainingService = $serviceLocator->getServiceLocator()->get("Training\Service\TrainingService");
      
        $submitAssignmentFormForm = $serviceLocator->getServiceLocator()
            ->get('FormElementManager')
            ->get("Training\Form\SubmiMilestoneAnswerForm");
           
        $ctr->setEntityManager($generalService->getEntityManager())
            ->setRenderer($generalService->getRenderer())
            ->setShowAssignmentForm($submitAssignmentFormForm)
            ->setGeneralService($generalService)
            ->setTrainingService($trainingService);
        return $ctr;
    }
}

