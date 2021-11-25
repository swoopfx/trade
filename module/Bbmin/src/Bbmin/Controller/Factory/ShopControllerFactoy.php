<?php
namespace Bbmin\Controller\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Bbmin\Controller\ShopController;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class ShopControllerFactoy implements FactoryInterface
{

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $ctr = new ShopController();
        /**
         *
         * @var GeneralService $generalService
         */
        $generalService = $serviceLocator->getServiceLocator()->get("General\Service\GeneralService");
        $bbminService = $serviceLocator->getServiceLocator()->get("Bbmin\Service\BbminService");
        $productForm = $serviceLocator->getServiceLocator()
            ->get("FormElementManager")
            ->get("Shop\Form\ProductForm");
        
        $dropzoneform = $serviceLocator->getServiceLocator()
            ->get("FormElementManager")
            ->get("dropzoneForm");
        
        $productCategoryForm = $serviceLocator->getServiceLocator()
            ->get("FormElementManager")
            ->get("Shop\Form\ProductCategoryForm");
        
        $uploadService = $serviceLocator->getServiceLocator()->get("General\Service\UploadService");
        
        $productPageAdapter = $serviceLocator->getServiceLocator()->get("Shop\Paginator\ProductAdapter");
        $ctr->setEntityManager($generalService->getEntityManager())
            ->setProductPageAdapter($productPageAdapter)
            ->setProductCategoryForm($productCategoryForm)
            ->setUploadService($uploadService)
            ->setBbminService($bbminService)
            ->setDropZoneForm($dropzoneform)
            ->setProductForm($productForm);
        
        return $ctr;
    }
}

