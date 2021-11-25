<?php
namespace Training\Paginator\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Training\Paginator\TrainingAdapter;
use Training\Entity\Training;
use Laminas\Paginator\Paginator;

/**
 *
 * @author otaba
 *        
 */
class TrainingAdapterFactory implements FactoryInterface
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
        $adapter = new TrainingAdapter();
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $entityManager = $generalService->getEntityManager();
        $trainingRepository = $entityManager->getRepository(Training::class);
        $adapter->setRepository($trainingRepository);
        
        $page = $serviceLocator->get("Application")
            ->getMvcEvent()
            ->getRouteMatch()
            ->getParam("page");
        $paginator = new Paginator($adapter);
//         var_dump($paginator);
//         $paginator->setCurrentPageNumber($page)->setItemCountPerPage(8);
//         var_dump($paginator);
        return $paginator;

    }
}

