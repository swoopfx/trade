<?php
namespace Bbmin\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Bbmin\Controller\ProductjsonController;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class ProductjsonControllerFactory implements FactoryInterface
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
        $ctr = new ProductjsonController();
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $bbminService = $serviceLocator->getServiceLocator()->get("Bbmin\Service\BbminService");
        $uploadService = $serviceLocator->getServiceLocator()->get("General\Service\UploadService");
        $productForm = $serviceLocator->getServiceLocator()
            ->get("FormElementManager")
            ->get("Shop\Form\ProductForm");
        
        $productInputFilter = $serviceLocator->getServiceLocator()
            ->get("InputFilterManager")
            ->get("Shop\Form\Fieldset\ProductFieldsetInputFilter");
        
            
        
        $ctr->setEntityManager($generalService->getEntityManager())
            ->setUploadService($uploadService)
            ->setProductForm($productForm)
            ->setProductInputFilter($productInputFilter)
            ->setBbminService($bbminService);
            
        return $ctr;
    }
}

