<?php
namespace Wallet\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Wallet\Controller\ReferalController;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class ReferalControllerFactory implements FactoryInterface
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
        $ctr = new ReferalController();
       
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $referalService = $serviceLocator->getServiceLocator()->get("Wallet\Service\ReferalService");
        $referalForm = $serviceLocator->getServiceLocator()->get("FormElementManager")->get("Wallet\Form\WalletReferalForm");
//         var_dump($referalService);
        $ctr->setEntityManager($generalService->getEntityManager())
            ->setReferalService($referalService)
            ->setRenderer($generalService->getRenderer())
            ->setReferalForm($referalForm)
            ->setGeneralService($generalService);
        
        return $ctr;
    }
}

