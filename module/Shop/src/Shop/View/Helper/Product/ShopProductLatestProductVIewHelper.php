<?php
namespace Shop\View\Helper\Product;

use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Shop\Service\ProductService;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class ShopProductLatestProductVIewHelper extends AbstractHelper implements ServiceLocatorAwareInterface
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

    public function __invoke()
    {
        $html = "";
        /**
         * 
         * @var ProductService $productService
         */
        $productService = $this->getServiceLocator()
            ->getServiceLocator()
            ->get("Shop\Service\ProductService");
        $entity = $productService->getMostRecentProduct();
        $html = $this->frames($entity);
        
        return $html;
        // $latesProducts =
    }

    private function frames($data)
    {
        $fram = "";
        $myCurrencyHelper = $this->getServiceLocator()
            ->getServiceLocator()
            ->get("ViewHelperManager")
            ->get("myCurrencyHelper");
            $url = $this->getServiceLocator()
            ->getServiceLocator()
            ->get("ViewHelperManager")
            ->get("url");
     
            if (count($data) > 0) {
                $limit = (count($data) > 4 ? 4 : count($data));
                for ($i = 0; $i < $limit; $i++) {
                    $link = $url("product", array("id"=>$data[$i]['productUid'], "name"=>GeneralService::spine($data[$i]['productDescription']['productName'])));
                   
//                     $fram .= "HYYYY";
                    
                    $fram .= "
			<div class='col-sm col-md-6 col-lg ftco-animate'>
				<div class='product'>
                   
					<a href='{$link}' class='img-prod'><img class='img-fluid' src=" . ProductService::noImageOnproduct($data[$i]) . ">
						<div class='overlay'></div>
					</a>
                 
					<div class='text py-3 px-3'>
						<h3>
							<a href='#'>".$data[$i]["productDescription"]["productName"]."</a>
						</h3>
						<div class='d-flex'>
							<div class='pricing'>
								<p class='price'>
									<span> ".$myCurrencyHelper(ProductService::getActivePrice($data[$i]))."</span>
								</p>
							</div>
							
						</div>
						<p class='bottom-area d-flex px-3'>
							 <a href='{$link}' class='buy-now text-center py-2'>Buy now<span><i class='ion-ios-cart ml-1'></i></span></a>
						</p>
					</div>
				</div>
			</div>
		";
                }
                return $fram;
            }
        
    }
}

