<?php
namespace Shop\View\Helper;

use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Settings\Service\SettingsService;

/**
 *
 * @author otaba
 *        
 */
class ShopFooterAddressHelper extends AbstractHelper implements ServiceLocatorAwareInterface
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

    public function __invoke(){
        /**
         * 
         * @var SettingsService $settingsService
         */
        $settingsService = $this->getServiceLocator()->getServiceLocator()->get("Settings\Service\SettingsService");
        
        return $this->frame($settingsService->getShopAdress());
    }
    
    
    private function frame($data){
        if($data != NULL){
        $html = "<div class='block-23 mb-3'>
							<ul>
								<li><span class='icon icon-map-marker'></span><span class='text'>{$data["fulladdress"]}</span></li>
								<li><a href='#'><span class='icon icon-phone'></span><span
										class='text'>{$data["phone"]}</span></a></li>
								<li><a href='#'><span class='icon icon-envelope'></span><span
										class='text'>{$data["email"]}</span></a></li>
							</ul>
						</div>";
        return $html;
        }
    }
}

