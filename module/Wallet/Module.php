<?php
namespace Wallet;

use Laminas\ModuleManager\Feature\AutoloaderProviderInterface;
use Laminas\Mvc\ModuleRouteListener;
use Laminas\Mvc\MvcEvent;
use Laminas\ModuleManager\ModuleManager;

class Module implements AutoloaderProviderInterface
{

    public function getAutoloaderConfig()
    {
        return array(
            'Laminas\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $app = $e->getApplication();
        $sm = $app->getServiceManager();
        
        $em = $sm->get("doctrine.entitymanager.orm_default");
        $eventManager = $app->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $sharedManager = $eventManager->getSharedManager();
        $sharedManager->attach("Laminas\Mvc\Controller\AbstractActionController", \General\Service\TriggerService::REFERAL_INITIATED, function($e) use($sm){
            // Sends an email
            // sends an sms
            ///
        });

    }

//     private function sss($sm)
//     {
//         // $app = $e->getApplication();
//         // $sm = $app->getServiceManager();
//         $em = $sm->get("doctrine.entitymanager.orm_default");

//         $loEntity = new \Home\Entity\LoggerTest();
//         $loEntity->setLoggedDate(new \DateTime());

//         $em->persist($loEntity);
//         $em->flush();
//     }

    public function init(ModuleManager $moduleManager)
    {
       
        $sharedEvent = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvent->attach(__NAMESPACE__, 'dispatch', function ($e) {
            $controller = $e->getTarget();
            $controller->layout('layout/slim');
        });
        
//         $sharedEvent
    }
}