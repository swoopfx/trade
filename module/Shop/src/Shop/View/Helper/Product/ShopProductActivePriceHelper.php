<?php
namespace Shop\View\Helper\Product;

use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Shop\Entity\Product;

/**
 *
 * @author otaba
 *        
 */
class ShopProductActivePriceHelper extends AbstractHelper implements ServiceLocatorAwareInterface
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
     *
     * @param Product $product            
     */
    public function __invoke($product)
    {
        $mycurrencyHelper = $this->getServiceLocator()
            ->getServiceLocator()
            ->get("ViewHelperManager")
            ->get("myCurrencyHelper");
        if (is_array($product)) {
            if ($product['isDiscount']) {
                return "<span><del>{$mycurrencyHelper($product["price"])}</del></span> | <span>{$mycurrencyHelper($product["discount"]["price"])}</span>";
            } else {
                return "<span>{$mycurrencyHelper($product["price"])}</span>";
            }
        } else {
            if ($product->getIsDiscount()) {
                return "<span><del>{$mycurrencyHelper($product->getPrice())}</del></span>  | <span>{$mycurrencyHelper($product->getDiscount()->getPrice())}</span>";
            } else {
                return "<span>{$mycurrencyHelper($product->getPrice())}</span>";
            }
        }
    }
}

