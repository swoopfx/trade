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
class ShopProductCategorizeHelper extends AbstractHelper implements ServiceLocatorAwareInterface
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
        $tml = "";
        /**
         *
         * @var ProductService $shopProductService
         */
        $shopProductService = $this->getServiceLocator()
            ->getServiceLocator()
            ->get("Shop\Service\ProductService");
        $allCategory = $shopProductService->getAllShopCategory();
        if (count($allCategory)) {
            foreach ($allCategory as $category) {
                $tml .= $this->framee($category);
            }
        }
        return $tml;
    }

    private function framee($category)
    {
        $html = "";
        $shopProductService = $this->getServiceLocator()
            ->getServiceLocator()
            ->get("Shop\Service\ProductService");
        $categorizeProductSnippet = $shopProductService->getCategorizeProductSnippet($category->getId());
        if (count($categorizeProductSnippet) > 0) {
            $html .= "<section class='ftco-section bg-light'>
    	<div class='container'>
				<div class='row justify-content-center mb-3 pb-3'>
          <div class='col-md-12 heading-section ftco-animate'>
          <h2 class='mb-4'>{$category->getCategory()}</h2>
              </div>
        </div>   		
    	</div>
    	<div class='container'>
    		<div class='row'>
    			
    			{$this->innerFame($category)}
				
    		</div>
    	</div>
    </section>";
        }
        return $html;
    }

    private function innerFame($category)
    {
        $html = "";
        /**
         *
         * @var ProductService $shopProductService
         */
        $shopProductService = $this->getServiceLocator()
            ->getServiceLocator()
            ->get("Shop\Service\ProductService");
        $viewManager = $this->getServiceLocator()
            ->getServiceLocator()
            ->get("ViewHelperManager");
        $shopProductActivePrice = $viewManager->get('shopProductActivePrice');
        $url = $viewManager->get('url');
        $categorizeProductSnippet = $shopProductService->getCategorizeProductSnippet($category->getId());
        
        if (count($categorizeProductSnippet) > 0) {
            foreach ($categorizeProductSnippet as $cat) {
                $link = $url('product', array('id'=>$cat->getProductUid(), 'name'=>GeneralService::spine($cat->getProductDescription()->getProductName())));
                // var_dump($cat->getProductUid())
                $html .= "<div class='col-sm col-md-6 col-lg ftco-animate'>
    				<div class='product'>
    				<a href='{$link}' class='img-prod'><img class='img-fluid' src='{$cat->getImage()[0]->getThumbnail()}' alt='{$cat->getProductDescription()->getProductName()}'>
    						<div class='overlay'></div>
    					</a>
    					<div class='text py-3 px-3'>
    						<h3><a href='#'>{$cat->getProductDescription()->getProductName()}</a></h3>
    						<div class='d-flex'>
    							<div class='pricing'>
		    						<p class='price'><span>{$shopProductActivePrice($cat)}</span></p>
		    					</div>
		    					
	    					</div>
    						<p class='bottom-area d-flex px-3'>     							
    							<a href='{$link}' class='buy-now text-center py-2'>View Product<span><i class='ion-ios-cart ml-1'></i></span></a>
    						</p>
    					</div>
    				</div>
    			</div>";
            }
        }
        return $html;
    }
}

