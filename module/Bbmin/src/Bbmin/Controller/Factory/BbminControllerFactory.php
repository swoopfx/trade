<?php
namespace Bbmin\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Bbmin\Controller\BbminController;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class BbminControllerFactory implements FactoryInterface
{

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $ctr = new BbminController();
        /**
         * 
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $bbminService = $serviceLocator->getServiceLocator()->get("Bbmin\Service\BbminService");
        $trainingService = $serviceLocator->getServiceLocator()->get("Training\Service\TrainingService");
        $entityManager = $generalService->getEntityManager();
        $ctr->setEntityManager($entityManager)->setTrainingService($trainingService);
        return $ctr;
    }
}

