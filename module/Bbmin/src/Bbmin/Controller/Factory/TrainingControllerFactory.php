<?php
namespace Bbmin\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Bbmin\Controller\TrainingController;
use Laminas\Session\Container;
use General\Service\GeneralService;
use General\Paginator\PaginatorAdapter;

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
        $trainingSession = new Container(GeneralService::SESSION_TRAINING);
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $trainingService = $serviceLocator->getServiceLocator()->get("Training\Service\TrainingService");
        $uploadService = $serviceLocator->getServiceLocator()->get("General\Service\UploadService");
        $trainingPaginator = $serviceLocator->getServiceLocator()->get("Bbmin\Paginator\TrainingAdminPaginator");
        $paginatorAdapter = $serviceLocator->getServiceLocator()->get(PaginatorAdapter::class);
        $viewrenderer = $serviceLocator->getServiceLocator()->get("ViewRenderer");
        $ctr->setTrainingSession($trainingSession)
            ->setGeneralService($generalService)
            ->setTrainingService($trainingService)
            ->setTrainingPaginator($trainingPaginator)
            ->setUploadService($uploadService)
            ->setPaginator($paginatorAdapter)
            ->setEntityManager($generalService->getEntityManager());
        return $ctr;
    }
}

