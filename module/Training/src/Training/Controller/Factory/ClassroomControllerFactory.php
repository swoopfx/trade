<?php
namespace Training\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Training\Controller\ClassroomController;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class ClassroomControllerFactory implements FactoryInterface
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
        $ctr = new ClassroomController();
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $classroomService = $serviceLocator->getServiceLocator()->get("Training\Service\ClassroomService");
        $youtubeApiService = $serviceLocator->getServiceLocator()->get("Training\Service\YoutubeApiService");
        $ctr->setEntityManager($generalService->getEntityManager())
            ->setClassroomService($classroomService)
            ->setYoutibeApiService($youtubeApiService)
            ->setGeneralService($generalService);
        return $ctr;
    }
}

