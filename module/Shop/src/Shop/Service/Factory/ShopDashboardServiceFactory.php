<?php
namespace Shop\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Shop\Service\ShopDashboardService;

/**
 *
 * @author otaba
 *        
 */
class ShopDashboardServiceFactory implements FactoryInterface
{

    /**
     */
    public function __construct()
    {}

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        
        $xserv = new ShopDashboardService();
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $xserv->setEntityManager($generalService->getEntityManager())
            ->setAuth($generalService->getAuth())
            ->setUserId($generalService->getUserId());
       
        return $xserv;
    }
}

