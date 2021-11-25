<?php
namespace Wallet\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Wallet\Service\ReferalService;

/**
 *
 * @author otaba
 *        
 */
class ReferalServiceFactory implements FactoryInterface
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
        $xserv = new ReferalService();
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $xserv->setEntityManager($generalService->getEntityManager())
            ->setAuth($generalService->getAuth())
            ->setUserId($generalService->getUserId())
            ->setGeneralSerivce($generalService)
            ->setGeneralSession($generalService->getGeneralSession());
        return $xserv;
    }
}

