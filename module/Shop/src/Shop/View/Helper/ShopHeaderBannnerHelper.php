<?php
namespace Shop\View\Helper;

use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author otaba
 *        
 */
class ShopHeaderBannnerHelper extends AbstractHelper implements ServiceLocatorAwareInterface
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
        
    }
    
    
    
    private function framme(){
        $html = "<div class='hero-wrap hero-bread'
	style='background-image: url('/shop/images/bg_6.jpg');'>
	<div class='container'>
		<div
			class='row no-gutters slider-text align-items-center justify-content-center'>
			<div class='col-md-9 ftco-animate text-center'>
				<p class='breadcrumbs'>
					<span class='mr-2'><a href='index.html'>Home</a></span> <span>About</span>
				</p>
				<h1 class='mb-0 bread'>About Us</h1>
			</div>
		</div>
	</div>
</div>";
    }
}

