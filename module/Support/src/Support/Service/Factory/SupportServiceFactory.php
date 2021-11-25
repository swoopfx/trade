<?php
namespace Support\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Support\Service\SupportService;
use Laminas\Session\Container;

/**
 *
 * @author otaba
 *        
 */
class SupportServiceFactory implements FactoryInterface
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
        $xserve = new SupportService();
        $messageSession = new Container("message_session");
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $xserve->setEntityManager($generalService->getEntityManager())
            ->setUserId($generalService->getUserId())
            ->setMessageSession($messageSession)
            ->setAuth($generalService->getAuth());
        return $xserve;
    }
}

