<?php
namespace Support\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Support\Controller\SupportmodalController;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class SupportmodalControllerFactory implements FactoryInterface
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
        $ctr = new SupportmodalController();
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $wysiwygForm = $serviceLocator->getServiceLocator()
            ->get("FormElementManager")
            ->get("Support\Form\SupportWYSIWYGForm");
        
        $supportForm = $serviceLocator->getServiceLocator()
            ->get("FormElementManager")
            ->get("Support\Form\SupportForm");
        $supportService = $serviceLocator->getServiceLocator()->get("Support\Service\SupportService");
        $em = $generalService->getEntityManager();
        $renderer = $generalService->getRenderer();
        $ctr->setEntityManager($em)
            ->setRenderer($renderer)
            ->setGenerralService($generalService)
            ->setSupportForm($supportForm)
            ->setSupportService($supportService)
            ->setWysiwygForm($wysiwygForm);
        return $ctr;
    }
}

