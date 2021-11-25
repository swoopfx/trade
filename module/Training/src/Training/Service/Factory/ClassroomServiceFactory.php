<?php
namespace Training\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Training\Service\ClassroomService;
use Laminas\Session\Container;

/**
 *
 * @author otaba
 *        
 */
class ClassroomServiceFactory implements FactoryInterface
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
        
        $xserv = new ClassroomService();
        $classroomSession = new Container("classroom_session");
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        $xserv->setEntityManager($generalService->getEntityManager())->setClassroomSession($classroomSession)->setAuth($generalService->getAuth());
        return $xserv;
    }
}

