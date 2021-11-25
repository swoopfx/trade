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
class ShopHomeSpashHelper extends AbstractHelper implements ServiceLocatorAwareInterface
{

    private $servicelocator;

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
        $viewHelperManager = $this->getServiceLocator()->getServiceLocator()->get("ViewHelperManager");
        $partial = $viewHelperManager->get("partial");
        
//         var_dump($viewHelperManager);
        /**
         *
         * @var ShopDashboardService $shopDashboardService
         */
        $shopDashboardService = $this->getServiceLocator()
            ->getServiceLocator()
            ->get("Shop\Service\ShopDashboardService");
        $entity = $shopDashboardService->getShopDashboardSplash();
        return $this->frame($entity, $viewHelperManager);
    }

    public function frame($data,  $view = NULL)
    {
        $url = $view->get("url");
        $imageTop = ($data->getImageTop() != NULL ? $data->getImageTop()->getImageUrl() : "");
        $topH2Text = ($data->getH2HeaderTop() != NULL ? $data->getH2HeaderTop() : "");
        $paragraphTextTop = ($data->getParagraphTop() != NULL ? $data->getParagraphTop() : "");
        $buttonTop = ($data->getIsButtonTop() == TRUE ? "<p>
            <a href='{$url("products/default", array("action"=>"categorize"))}' class='btn btn-white px-4 py-3'>Shop now</a>
					</p>" : "");
        
        
        
        $imageBottom = ($data->getImageBottom() != NULL ? $data->getImageBottom()->getImageUrl() : "");
        $bottomH2Text = ($data->getH2HeaderBottom() != NULL ? $data->getH2HeaderBottom() : "");
        $paragraphTextBottom = ($data->getParagraphBottom() != NULL ? $data->getParagraphBottom() : "");
        $buttonBottom = ($data->getIsButtonBottom() == TRUE ? "<p>
            <a href='{$url("products/default", array("action"=>"categorize"))}' class='btn btn-white px-4 py-3'>Engage</a>
            </p>" : "");
        
        
        $html = "<section class='ftco-section ftco-choose ftco-no-pb ftco-no-pt bg-light'>
	<div class='container'>
		<div class='row'>
			<div class='col-md-8 d-flex align-items-stretch'>
				<div class='img'
				style='background-image: url({$imageTop});'></div>
			</div>
			<div class='col-md-4 py-md-5 ftco-animate'>
				<div class='text py-3 py-md-5'>
					<h2 class='mb-4'>{$topH2Text}</h2>
					<p>{$paragraphTextTop}</p>
					{$buttonTop}
				</div>
			</div>
		</div>

		<div class='row'>
			<div class='col-md-5 order-md-last d-flex align-items-stretch'>
				<div class='img img-2'
					style='background-image: url({$imageBottom});'></div>
			</div>
			<div class='col-md-7 py-3 py-md-5 ftco-animate'>
				<div class='text text-2 py-md-5'>
					<h2 class='mb-4'>{$bottomH2Text}</h2>
					<p>{$paragraphTextBottom}</p>
					{$buttonBottom}
				</div>
			</div>
		</div>
	</div>
</section>

";
        return $html;
    }
}

