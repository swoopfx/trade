<?php
namespace Bbmin\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Bbmin\Service\BbminService;
use Laminas\Session\Container;

/**
 *
 * @author otaba
 *        
 */
class BbminServiceFactoryInterface implements FactoryInterface
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
        
        $xserv = new BbminService();
        $addProductSession = new Container(BbminService::BBMIN_ADD_PRODUCT_SESSION_KEY);
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $entityManager = $generalService->getEntityManager();
        $xserv->setEntityManager($entityManager)->setAddProductSession($addProductSession);
        return $xserv;
    }
}

