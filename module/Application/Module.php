<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Laminas\Mvc\ModuleRouteListener;
use Laminas\Mvc\MvcEvent;
use Laminas\ModuleManager\ModuleManager;
use General\Service\TriggerService;
use Wallet\Entity\Wallet;
use Wallet\Entity\Credit;
use Wallet\Service\WalletService;
use Wallet\Service\CreditService;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $app = $e->getApplication();
        $sm = $e->getApplication()->getServiceManager();
        $sharedEventManager = $app->getEventManager()->getSharedManager();
//         $sharedEventManager->attach("Laminas\Mvc\Controller\AbstractActionController", TriggerService::USER_REGISTER_COMPLETE, function($e) use ($sm){
//             // Hydrate wallet 
//             // Hydrate credit
//             $em = $sm->get("doctrine.entitymanager.orm_default");
            
//             $user = $e->getParam("user");
            
//             $walletEntity = new Wallet();
//             $creditEntity = new Credit();
            
//             $walletEntity->setBalance(0)
//             ->setBookBalance(0)
//             ->setCreatedOn(new \DateTime())
//             ->setUser($em->find("CsnUser\Entity\user", $user))
//             ->setWalletUid(WalletService::generateWalletUid());
            
//             $creditEntity->setCreatedOn(new \DateTime())
//             ->setCreditBonus(0)
//             ->setCreditLimit(CreditService::USER_CREDIT_LIMIT)
//             ->setUser($em->find("CsnUser\Entity\user", $user));
            
//             try {
                
//                 $em->persist($walletEntity);
//                 $em->persist($creditEntity);
                
//                 $em->flush();
//             } catch (\Exception $e) {
//                 // log error
// //                 var_dump($expression)
//             }
//         });
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Laminas\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function init(ModuleManager $moduleManager){
        $sharedEvent = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvent->attach(__NAMESPACE__, 'dispatch', function ($e) {
            $controller = $e->getTarget();
            $controller->layout('layout/slim');
            
        });
    }
}
