<?php
namespace Bbmin\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Bbmin\Controller\CustomerController;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class CustomerControllerFactory implements FactoryInterface
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
        
        $ctr = new CustomerController();
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $em = $generalService->getEntityManager();
        $customerPaginator = $serviceLocator->getServicelocator()->get("Bbmin\Paginator\CustomerAdapter");
        $countryPaginator = $serviceLocator->getServiceLocator()->get("Bbmin\Paginator\CountryAdapter");
        $ctr->setCustomerPaginator($customerPaginator)->setEntityManager($em)->setCountryPaginator($countryPaginator);
        return $ctr;
    }
}

