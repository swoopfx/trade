<?php
namespace Shop\View\Helper\Wallet;

use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Shop\Entity\Product;
use General\Service\GeneralService;
use Shop\Entity\ProductDescription;
use Shop\Service\ProductService;

/**
 *
 * @author otaba
 *        
 */
class WalletHighPointProductHelper extends AbstractHelper implements ServiceLocatorAwareInterface
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
        
        // TODO - Insert your code here
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
        /**
         *
         * @var ProductService $productService
         */
        $productService = $this->getServiceLocator()
            ->getServiceLocator()
            ->get("Shop\Service\ProductService");
        $framee = $this->frame($productService->getHighPointProducts());
        return $framee;
    }

    private function frame(Product $products)
    {
        /**
         *
         * @var GeneralService $generalService
         */
        $myCurrencyHelper = $this->getServiceLocator()->getServiceLocator()->get("ViewHelperManager")->get("myCurrencyHelper");
        // $em = $generalService->getEntityManager();
        if (count($products) > 0) {
            for ($i = 0; $i < 3; $i ++) {
               
                $framee .= "<div class='col-md-6 col-lg-4'>
				<div class='card card-popular-product'>
					<label class='prod-id'>Product SKU: " . ProductService::getProductSku($products[$i]) . "</label>
					<h5 class='prod-name'>
						<a href=''>" . ProductService::getProductName($products[$i]) . "</a>
					</h5>
					<p class='prod-by'>
						Minimum Qty: <a href=''>".ProductService::getPointMinQuantity($products[$i])."</a>
					</p>
					<div class='row'>
						<div class='col-5'>
							<h1>".ProductService::getProductPoints($products[$i])."</h1>
							<p>Points</p>
						</div>
						<!-- col -->
						<div class='col-7'>
							<h1>".$myCurrencyHelper(ProductService::getProductPrice($products[$i]))."</h1>
							<p>Price</p>
						</div>
						<!-- col -->
					</div>
					<!-- row -->
				</div>
				<!-- card -->
			</div>
			<!-- col-4 -->
			";
            }
        }
        return $framee;
    }
}

