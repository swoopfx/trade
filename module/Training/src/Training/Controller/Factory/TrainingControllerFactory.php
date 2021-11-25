<?php
namespace Training\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Training\Controller\TrainingController;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class TrainingControllerFactory implements FactoryInterface
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
        $ctr = new TrainingController();
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $trainingService = $serviceLocator->getServiceLocator()->get("Training\Service\TrainingService");
        $viewrenderer = $serviceLocator->getServiceLocator()->get("ViewRenderer");
        $trainingPaginator = $serviceLocator->getServiceLocator()->get("Training\Paginator\TrainingAdapter");
        $ctr->setRenderer($viewrenderer)
            ->setEntityManager($generalService->getEntityManager())
            ->setTrainingPaginator($trainingPaginator)
            ->setTrainingService($trainingService);
        return $ctr;
    }
}

