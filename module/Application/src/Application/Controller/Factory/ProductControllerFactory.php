<?php
namespace Application\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Application\Controller\ProductController;

/**
 *
 * @author mac
 *        
 */
class ProductControllerFactory implements FactoryInterface
{

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
     */
    public function createService(\Laminas\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $ctr = new ProductController();
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $uploadService = $serviceLocator->getServiceLocator()->get("General\Service\UploadService");
        $ctr->setEntityManager($generalService->getEntityManager())
            ->setUploadService($uploadService)
            ->setGeneralService($generalService);
        return $ctr;
    }
}

