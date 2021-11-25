<?php
namespace Bbmin\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Bbmin\Controller\TrainingjsonController;
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
        $trainingService = $serviceLocator->getServiceLocator()->get("Training\Service\TrainingService");
        $programmesService = $serviceLocator->getServiceLocator()->get("Training\Service\ProgrammesService");
       
        $courseForm = $serviceLocator->getServiceLocator()->get("FormElementManager")->get("Training\Form\CourseForm");
       
        $viewrenderer = $serviceLocator->getServiceLocator()->get("ViewRenderer");
        
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        
        $uploadService = $serviceLocator->getServiceLocator()->get("General\Service\UploadService");
        $ctr->setEntityManager($generalService->getEntityManager())
            ->setTrainingService($trainingService)
            ->setRenderer($viewrenderer)
            ->setCourseForm($courseForm)
            ->setUploadService($uploadService)
            ->setProgrammesService($programmesService);
        return $ctr;
    }
}

