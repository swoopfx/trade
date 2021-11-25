<?php
namespace Shop\View\Helper\Dashboard;

use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Shop\Service\ShopDashboardService;

/**
 *
 * @author otaba
 *        
 */
class ShopHomeMainCarouselHelper extends AbstractHelper implements ServiceLocatorAwareInterface
{

    private $servicelocator;

    /**
     */
    public function __construct()
    {}

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
     *
     */
    public function getServiceLocator()
    {
        return $this->servicelocator;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
     *
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->servicelocator = $serviceLocator;
        return $this;
    }

    public function __invoke()
    {
        /**
         *
         * @var ShopDashboardService $shopDashboardService
         */
        $shopDashboardService = $this->getServiceLocator()
            ->getServiceLocator()
            ->get("Shop\Service\ShopDashboardService");
        $entity = $shopDashboardService->getShopDashboardMainCarourel();
        
        return $this->frame($entity);
    }

    private function frame($datas)
    {
        $html = "";
        $transalate = "properties: { translateY: '70%' }";
        if (count($datas) > 0) {
            $html .= "<section id='home-section' class='hero'>
	<div class='home-slider js-fullheight owl-carousel'>";
            foreach ($datas as $data) {
                $html .= "<div class='slider-item js-fullheight'>
	      	<div class='overlay'></div>
	        <div class='container-fluid p-0'>
	          <div class='row d-md-flex no-gutters slider-text js-fullheight align-items-center justify-content-end' data-scrollax-parent='true'>
	          	<div class='one-third order-md-last img js-fullheight' style='background-image:url({$data->getBgImage()->getImageUrl()});'>
	          	</div>
		          <div class='one-forth d-flex js-fullheight align-items-center ftco-animate' >
		          	<div class='text'>
		          		<span class='subheading'>{$data->getSubheading()}</span>
		          		<div class='horizontal'>
		          			<h3 class='vr' style='background-image: url(/shop/images/divider.jpg);'>" . strtoupper($data->getVrH3Text()) . "</h3>
				            <h1 class='mb-4 mt-3'>" . $data->getH1Text() . " <br><span>" . $data->getH1SpanText() . "</span></h1>
				            <p>" . $data->getParagraphText() . "</p>
				            
				            
				          </div>
		            </div>
		          </div>
	        	</div>
	        </div>
	      </div>";
            }
            $html .= "</div>
</section>";
            return $html;
        }
    }
}

