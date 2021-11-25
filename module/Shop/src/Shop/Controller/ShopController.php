<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Shop for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Shop\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\MvcEvent;
use Laminas\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;
use Shop\Entity\Category;
use Shop\Entity\Product;

class ShopController extends AbstractActionController
{

    /**
     * 
     * @var EntityManager
     */
    private $entityManager;
    
    /**
     * 
     * @var 
     */
    private $productCategoryPagination;

    public function onDispatch(MvcEvent $e){
    $respinse = parent::onDispatch($e);
//     $this->redirectPlugin()->redirectCondition();
    // $this->layout()->setTe
    }
    public function indexAction()
    {
        return array();
    }

    public function aboutAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function cartAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function checkoutAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function contactAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function shippingAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function returnsAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function privacyAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function termsAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function homeAction()
    {
        $this->layout()->setTemplate("layout/shop/home");
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function categoryAction()
    {
        $em = $this->entityManager;
        
        $categoryId = $this->params()->fromRoute("category");
        
        $products = $this->productCategoryPagination;
        
        $categoryEntity = $em->find(Category::class, $categoryId);
        // var_dump($products);
        $viewModel = new ViewModel(array(
            "products" => $products,
            "category"=>$categoryEntity
        ));
        return $viewModel;
    }

    public function catAction()
    {
        $em = $this->entityManager;
        $cat = $em->getRepository(Product::class)->findMostRecentProductsArray();
        return new JsonModel($cat);
    }

    public function productAction()
    {
        $viewModel = new ViewModel();
        
        return $viewModel;
    }
    
    public function shopCategoryAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
    public function salesAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
   
    /**
     * @param field_type $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }
    /**
     * @return the $productCategoryPagination
     */
    public function getProductCategoryPagination()
    {
        return $this->productCategoryPagination;
    }

    /**
     * @param field_type $productCategoryPagination
     */
    public function setProductCategoryPagination($productCategoryPagination)
    {
        $this->productCategoryPagination = $productCategoryPagination;
        return $this;
    }


}
