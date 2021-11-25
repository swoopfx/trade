<?php
namespace Bbmin\Paginator\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Bbmin\Paginator\TrainingAdminPaginator;
use Training\Entity\Training;
use Laminas\Paginator\Paginator;

class TrainingAdminPaginatorInterface implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $adapter = new TrainingAdminPaginator();
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $entityManager = $generalService->getEntityManager();
        $trainingRepository = $entityManager->getRepository(Training::class);
        $adapter->setTrainingRepository($trainingRepository);
        
        $page = $serviceLocator->get("Application")
        ->getMvcEvent()
        ->getRouteMatch()
        ->getParam("page");
        $paginator = new Paginator($adapter);
        //         var_dump($paginator);
                $paginator->setCurrentPageNumber($page)->setItemCountPerPage(50);
        //         var_dump($paginator);
        return $paginator;
    }
}

