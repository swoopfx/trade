<?php


namespace Bbmin\Paginator\Factory;


use Bbmin\Paginator\CountryAdapter;
use Bbmin\Paginator\CustomerAdapter;
use Laminas\Paginator\Paginator;
use Laminas\ServiceManager\ServiceLocatorInterface;

class CountryAdapterFactory implements \Laminas\ServiceManager\FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $adapter = new CountryAdapter();

        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $entityManager = $generalService->getEntityManager();
        $countryRepository = $entityManager->getRepository("Settings\Entity\Country");
        $adapter->setRepository($countryRepository);

        $page = $serviceLocator->get("Application")->getMvcEvent()->getRouteMatch()->getParam("page");

        $paginator = new Paginator($adapter);

        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(30);

        return $paginator;
    }
}