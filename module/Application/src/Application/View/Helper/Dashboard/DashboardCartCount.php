<?php
namespace Application\View\Helper\Dashboard;

use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Shop\Service\CartService;

/**
 *
 * @author otaba
 *        
 */
class DashboardCartCount extends AbstractHelper implements ServiceLocatorAwareInterface
{

    private $serviceLocator;

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
        /**
         * 
         * @var CartService $cardService
         */
        $cartService = $this->getServiceLocator()
            ->getServiceLocator()
            ->get("Shop\Service\CartService");
        
            $data = $cartService->getCartCount();
        
            return $data;
    }
}

