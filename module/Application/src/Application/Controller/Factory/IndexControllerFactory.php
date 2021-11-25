<?php
namespace Application\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Application\Controller\IndexController;

// use Application\Service\ApplicationService;
class IndexControllerFactory implements FactoryInterface
{

    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $ctr = new IndexController();
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $applicationService = $serviceLocator->getServiceLocator()->get("Application\Service\ApplicationService");
        $cartService = $serviceLocator->getServiceLocator()->get("Shop\Service\CartService");
        $cartOrderPaginator = $serviceLocator->getServiceLocator()->get("Shop\Paginator\CustomerOrderAdapter");
        // $redisCache = $serviceLocator->getServiceLocator()->get("General\Cache\Redis");
        // $uploadService = $serviceLocator->getServiceLocator()->get("General\Service\UploadService");
        $ctr->setGeneralService($generalService)
        ->setAppService($applicationService)
            ->setCartService($cartService)
            ->setCartOrderPaginator($cartOrderPaginator)
            ->setEntityManager($generalService->getEntityManager());
        return $ctr;
    }
    
    public function __invoke(){
        
    }
}

