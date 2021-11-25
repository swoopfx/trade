<?php
namespace Shop\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use General\Service\GeneralService;
use Shop\Service\ProductService;
use Shop\Paginator\ProductAdapter;
use Shop\Entity\Product;
use Laminas\Mvc\MvcEvent;

/**
 *
 * @author otaba
 *        
 */
class ProductController extends AbstractActionController
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;
    
    /**
     * 
     * @var unknown
     */
   private $odm;

    /**
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     *
     * @var ProductService
     */
    private $productService;

    /**
     *
     * @var ProductAdapter
     */
    private $productAdapter;
    
    
    public function onDispatch(MvcEvent $e){
        $response = parent::onDispatch($e);
//         $this->redirectPlugin()->redirectCondition();
        return $response;
    }

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
   

    /**
     * This action get a list of all products
     * 
     * {@inheritdoc}
     *
     * @see \Laminas\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction()
    {
        $name = $this->params()->fromRoute("name", NULL);
        $id = $this->params()->fromRoute("id", NULL);
        $viewModel = new ViewModel();
        if ($id == NULL) {
            // $this->layout()->setTemplate("layout/shoperror");
            $this->getResponse()->setStatusCode(404);
        } else {
            $productService = $this->productService;
            
            $productEntity = $productService->getProductEntity($id);
            
            $viewModel->setVariables(array(
                "data" => $productEntity
            ));
        }
        
        return $viewModel;
    }

    public function allAction()
    {
        $em = $this->entityManager;
        $productPaginator = $this->productAdapter;
//         var_dump($em->getRepository(Product::class)->publishedCountObject());
        $viewModel = new ViewModel([
            "products"=>$productPaginator
        ]);
        return $viewModel;
    }
    
    public function categoryAction(){
        $category = "MEN";
        $viewModel = new ViewModel([
            "category"=>$category
        ]);
        return $viewModel;
    }
    
    public function productAction(){
        $em = $this->entityManager;
        $request = $this->getRequest();
        $productId = $this->params()->fromRoute("id");
        $productName = $this->params()->fromRoute("name");
        if($productId == NULL){
            return $this->redirect()->toRoute("products");
        }else{
            $productId = strip_tags($productId);
            $productEntity = $em->getRepository(Product::class)->findOneBy([
                "productUid"=>$productId
            ]);
        }
        $viewModel = new ViewModel(array(
            "product"=>$productEntity
        ));
        return $viewModel;
    }
    

    
    
    
    public function categorizeAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }

    /**
     *
     * @return the $entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     *
     * @return the $generalService
     */
    public function getGeneralService()
    {
        return $this->generalService;
    }

    /**
     *
     * @return the $productService
     */
    public function getProductService()
    {
        return $this->productService;
    }

    /**
     *
     * @param \Doctrine\ORM\EntityManager $entityManager            
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     *
     * @param \General\Service\GeneralService $generalService            
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return $this;
    }

    /**
     *
     * @param \Shop\Service\ProductService $productService            
     */
    public function setProductService($productService)
    {
        $this->productService = $productService;
        return $this;
    }
    /**
     * @param \Shop\Paginator\ProductAdapter $productAdapter
     */
    public function setProductAdapter($productAdapter)
    {
        $this->productAdapter = $productAdapter;
        return $this;
    }

}

