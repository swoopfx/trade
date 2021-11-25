<?php
namespace Application\View\Helper\Dashboard;

use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Shop\Service\ProductService;

/**
 *
 * @author otaba
 *        
 */
class DashboardCarouselHelper extends AbstractHelper implements ServiceLocatorAwareInterface
{

    private $serviceLocator;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
     *
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
     *
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    /**
     * This function returns the 5 most recent products uploaded
     *
     * @return string
     */
    public function __invoke()
    {
        /**
         *
         * @var ProductService $productService
         */
        $productService = $this->getServiceLocator()
            ->getServiceLocator()
            ->get("Shop\Service\ProductService");
        $entity = $productService->getMostRecentProduct();
        $html = $this->frame($entity);
        
        return $html;
    }

    private function frame($data)
    {
        $myCurrencyHelper = $this->getServiceLocator()
            ->getServiceLocator()
            ->get("ViewHelperManager")
            ->get("myCurrencyHelper");
        if (is_array($data) || is_object($data)) {
            if (count($data) > 0) {
                for ($i = 0; $i < 4; $i ++) {
                    $active = ($i == 0 ? "active" : "");
                    
                    $html = "
<div class='carousel-item {$active}'>
										<div class=''>

											<div class='media media-demo'>
											<img src='" . ProductService::noImageOnproduct($data[$i]) . "' class='d-flex mg-r-40 wd-250'
													alt='Image'>
												<div class='media-body mg-t-20 mg-sm-t-0'>
													
													<div class='card card-popular-product'>
														<label class='prod-id'>" . ProductService::getProductSku($data[$i]) . "</label>
														<h5 class='prod-name'>
															<a href=''>" . ProductService::getProductName($data[$i]) . "</a>
														</h5>
														
														<div class='row'>

															<div class='col-12'>
																<h1>" . $myCurrencyHelper(ProductService::getProductPrice($data[$i])) . "</h1>

															</div>
															<!-- col -->
														</div>
														<!-- row -->
													</div>
													<!-- card -->
													<p>" . substr(ProductService::getProductDescription($data[$i], 0, 100)) . "....</p>
													
												</div>
												<!-- media-body -->
											</div>
										</div>
										<!-- carousel-item-wrapper -->
									</div>
									
									
									
									
";
                    return $html;
                }
            }
        }
    }
}

