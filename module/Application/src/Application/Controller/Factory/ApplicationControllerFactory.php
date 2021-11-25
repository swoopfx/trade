<?php
namespace Application\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Application\Controller\ApplicationController;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class ApplicationControllerFactory implements FactoryInterface
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
        $ctr = new ApplicationController();
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $applicationService = $serviceLocator->getServiceLocator()->get("Application\Service\ApplicationService");
        $completeProfileForm = $serviceLocator->getServiceLocator()
            ->get("FormElementManager")
            ->get("User\Form\UserProfileForm");
        
        $notifyPaymentForm = $serviceLocator->getServiceLocator()
            ->get("FormElementManager")
            ->get("Transaction\Form\NotifyPaymentForm");
           
        $ctr->setRenderer($generalService->getRenderer())
            ->setEntityManager($generalService->getEntityManager())
            ->setAuth($generalService->getAuth())
            ->setCompleteProfileForm($completeProfileForm)
            ->setApplicationService($applicationService)
            ->setNotifyPaymentForm($notifyPaymentForm)
            ->setGeneralService($generalService);
           
        return $ctr;
    }
    
   
}

