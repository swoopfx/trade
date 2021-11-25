<?php
namespace Transaction\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Transaction\Service\InvoiceService;

/**
 *
 * @author ezekiel
 *        
 */
class InvoiceServiceFactory implements FactoryInterface
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
        
        $xserv = new InvoiceService();
        $generalService = $serviceLocator->get("General\Service\GeneralService");
//         $generalService->getEntityManager()
        $xserv->setEntityManager($generalService->getEntityManager())->setGeneralService($generalService);
        
        return $xserv;
    }
}

