<?php
namespace Training\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Training\Service\TrainingService;
use Laminas\Session\Container;

/**
 *
 * @author otaba
 *        
 */
class TrainingServiceFactory implements FactoryInterface
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
        $xserv = new TrainingService();
        $trainingManagementSession = new Container("training_management_session");
        $trainingManagementSession->setExpirationSeconds(60 * 60 * 4);
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $xserv->setEntityManager($generalService->getEntityManager())
            ->setGeneralService($generalService)
            ->setTrainingManagementSession($trainingManagementSession);
        
        return $xserv;
    }
}

