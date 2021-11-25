<?php
namespace Bbmin\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Shop\Form\ProductForm;
use Laminas\Paginator\Paginator;
use Shop\Form\ProductCategoryForm;
use Shop\Entity\Category;
use Shop\Service\ShopService;
use General\Service\UploadService;
use Bbmin\Service\BbminService;
use Laminas\Session\Container;
use Shop\Service\ProductService;
use WasabiLib\Ajax\Response;
use Laminas\Mvc\MvcEvent;
use Shop\Entity\Product;
use CsnUser\Entity\Lastlogin;
use Settings\Entity\Color;
use General\Form\DropzoneForm;
use Shop\Entity\ProductFeatures;
use Laminas\View\Model\JsonModel;
use General\Service\GeneralService;

/**
 * ShopController
 *
 * @author
 *
 * @version
 *
 */
class ShopController extends AbstractActionController
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var ProductForm
     */
    private $productForm;

    /**
     *
     * @var Paginator
     */
    private $productPageAdapter;

    /**
     *
     * @var ProductCategoryForm
     */
    private $productCategoryForm;

    /**
     *
     * @var UploadService
     */
    private $uploadService;

    /**
     *
     * @var BbminService
     */
    private $bbminService;

    /**
     *
     * @var DropzoneForm
     *
     */
    private $dropZoneForm;

    public function onDispatch(MvcEvent $e)
    {
        $response = parent::onDispatch($e);
        $this->redirectPlugin()->redirectToLogout();
        $this->redirectPlugin()->adminRedirection();
        return $response;
    }

    /**
     * The default action - show the home page
     */
    public function indexAction()
    {
        // TODO Auto-generated ShopController::indexAction() default action
        return new ViewModel();
    }

    public function boardAction()
    {
        $viewmodel = new ViewModel(array());
        return $viewmodel;
    }
    
    
   

    /**
     * gets a list of products already inputed into the database
     *
     * @return \Laminas\View\Model\ViewModel
     */
    public function productAction()
    {
        $em = $this->entityManager;
        $products = $this->productPageAdapter;
//         var_dump($products);
        $viewModel = new ViewModel(array(
            "products" => $products
        ));
        return $viewModel;
    }

    /**
     * This action add additional product into the database
     *
     * @return \Laminas\View\Model\ViewModel
     */
    public function addproductAction()
    {
        $em = $this->entityManager;
        $addProductsession = $this->bbminService->getAddProductSession();
        $form = $this->productForm;
        // $form->setAttributes(array(
        // "action" => "processaddproduct"
        // ));
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $productEntity = new Product();
            $post = $request->getPost();
            $form->bind($productEntity);
            $form->setData($post);
            $form->setValidationGroup(array(
                "productFieldset" => array(
                    "productDescription" => array(
                        "productName",
                        "description",
                        "tag"
                    ),
                    "category",
                    "garmentType",
                    // "availableSizes",
                    "sku",
                    "quantity",
                    "isShipping",
                    "price",
                    "stockStatus",
                    "isDiscount",
                    "points",
                    "pointMinQuantity",
                    "tax",
                    "dateAvailable",
                    "weight",
                    "length",
                    "width",
                    "height",
                    "subtract",
                    "minimum"
                
                ),
                "csrf"
            
            ));
            if ($form->isValid()) {
                // var_dump("Valid");
                // Process features
                if (count($addProductsession->features) > 0) {
                    foreach ($addProductsession->features as $feature) {
                        $productFeature = new ProductFeatures();
                        $productFeature->setCreatedOn(new \DateTime())
                            ->setFeatureType($em->find("Settings\Entity\ProductFeatureType", $feature["type"]))
                            ->setFeaturInfo($feature["info"])
                            ->setProduct($productEntity);
                        
                        $em->persist($productFeature);
                    }
                    $productEntity->addProductFeatures();
                }
                
                if ($addProductsession->attributes) {}
                
                // TODO process validation of one to many relationaship
                // TODO if count of feature is greater than 0, operate hydration
                // TODO if count of Attributes is greater than 0, operate attributes hydrtaion
                
                $productEntity->setCreatedOn(new \DateTime())
                    ->setDateAvailable(new \DateTime())
                    ->setIsShipping(FALSE)
                    ->setProductUid(ProductService::generateProductUid())
                    ->setIsPublished(FALSE);
                
                try {
                    $em->persist($productEntity);
                    $em->flush();
                    $addProductsession->productid = $productEntity->getId();
                    
                    $response->setStatusCode(\Laminas\Http\Response::STATUS_CODE_201);
                    $jsonModel = new JsonModel();
                    $jsonModel->setVariables(array(
                        "id" => $addProductsession->productid
                    ));
                    return $jsonModel;
                } catch (\Exception $e) {
                    // $this->flashmessenger()->addErrorMessage("Product process error");
                    
                    $response->setStatusCode(\Laminas\Http\Response::STATUS_CODE_200);
                    return new JsonModel(array(
                        "error" => "Process Error"
                    ));
                }
            } else {
                
                $response->setStatusCode(\Laminas\Http\Response::STATUS_CODE_422);
                return new JsonModel(array(
                    "message" => $form->getInputFilter()->getMessages()[0]
                ));
            }
        } else {
            /**
             *
             * @var Container $addProductsession
             */
            
            $addProductsession->getManager()
                ->getStorage()
                ->clear(BbminService::BBMIN_ADD_PRODUCT_SESSION_KEY);
        }
        $viewModel = new ViewModel(array(
            "form" => $form
        ));
        return $viewModel;
    }
    
   

    public function manageproductAction()
    {
        $em = $this->entityManager;
        $addProductSession = $this->bbminService->getAddProductSession();
        $uid = $this->params()->fromRoute("id", NULL);
        if($uid == NULL){
            return $this->redirect()->toRoute("bbminshop/default", ["action"=>"shop"]);
        }
        $productEntity = $em->getRepository(Product::class)->findOneBy([
            "productUid"=>$uid
        ]);
        $addProductSession->productid = $productEntity->getId();
        $addProductSession->productUid = $productEntity->getProductUid();
        $viewModel = new ViewModel([
            "product"=>$productEntity
        ]);
        return $viewModel;
    }

    public function publishproductAction()
    {
        $em = $this->entityManager;
        $addProductSession = $this->bbminService->getAddProductSession();
        if (isset($addProductSession)) {
            if ($addProductSession->productid == NULL) {
                return $this->redirect()->toRoute("bbminshop/default", array(
                    "action" => "addproduct"
                ));
            }
            $dropzoneform = $this->dropZoneForm;
            $dropzoneform->setAttributes(array(
                "action" => $this->url()
                    ->fromRoute("bbminshop/default", array(
                    "action" => "publishproduct"
                ))
            ));
            $request = $this->getRequest();
            if ($request->isPost() || $request->isXmlHttpRequest()) {
                $files = $this->params()->fromFiles('file');
                $productEntity = $em->find(Product::class, $addProductSession->productid);
                $uploadService = $this->uploadService;
                $uploadService->upload($files);
            }
            $viewModel = new ViewModel(array(
                "dropzoneform" => $dropzoneform
            ));
            return $viewModel;
        }
    }
    
    public function managecategoryAction(){
        $em = $this->entityManager;
        
        $viewModel = new ViewModel();
        $categoryUid = $this->params()->fromRoute("id", NULL);
        if($categoryUid == NULL ){
            $this->flashmessenger()->addErrorMessage("Identifier Absent");
            $this->redirect()->toRoute("bbminshop/default", ["action"=>"category"]);
        }else{
            $categoryEntity = $em->getRepository(Category::class)->findOneBy([
                "categoryUid"=>$categoryUid
            ]);
            $viewModel->setVariables([
                "category"=>$categoryEntity
            ]);
        }
       
        return $viewModel;
    }

    public function categoryAction()
    {
        // $session = $this->bbminService->getAddProductSession();
        $em = $this->entityManager;
        $form = $this->productCategoryForm;
        $request = $this->getRequest();
        if ($request->isPost()) {
//             var_dump($this->getRequest()->getPost());
            $uploadService = $this->uploadService;
            $post = $request->getPost()->toArray();
            $files = $request->getFiles()->toArray();
            $merge = array_merge_recursive($post, $files);
            $categoryEntity = new Category();
            $form->bind($categoryEntity);
            $form->setData($merge);
            // validate form file upoad size
            if ($form->isValid()) {
                try {
                    $upload = $this->uploadService->upload($merge["productCategoryFieldset"]["image"]);
                    $data = $form->getData();
                    $categoryNme = strtoupper($data->getCategory());
                    $categoryEntity->setCategory($categoryNme)
                    ->setCategoryUid(ShopService::generateCategoryUid())->setSlug(GeneralService::spine($data->getCategory()))
                        ->setDateAdded(new \DateTime())
                        ->setImage($upload);
                    
                    $em->persist($categoryEntity);
                    $em->persist($upload);
                    $em->flush();
                    
                    $this->redirect()->toRoute("bbminshop/default", ["[action"=>"managecategory", "id"=>$categoryEntity->getCategoryUid()]);
                } catch (\Exception $e) {
                    $this->flashmessenger()->addErrorMessage($e->getMessage());
                    return $this->redirect()->refresh();
                }
            } else {
                // var_dump($form->getInputFilter()->getMessages());
                $this->flashmessenger()->addErrorMessage($form->getInputFilter()
                    ->getMessages());
                return $this->redirect()->refresh();
            }
        }
        $category = $em->getRepository("Shop\Entity\Category")->findAll();
        $viewModel = new ViewModel(array(
            "form" => $form,
            "category" => $category
        ));
        return $viewModel;
    }
    
    public function userChackoutTransactionAction(){
        $jsonModel = new JsonModel();
        $data = $this->params()->fromQuery();
        if($data != NULL){
            
        }
        return $jsonModel;
    }
    
    /**
     * @var 
     */
    public function orderTransactionsAction(){
        $jsonModel = new JsonModel();
        return $jsonModel;
    }

    public function setEntityManager($em)
    {
        $this->entityManager = $em;
        
        return $this;
    }

    public function setProductForm($form)
    {
        $this->productForm = $form;
        return $this;
    }

    /**
     *
     * @param \Laminas\Paginator\Paginator $productPageAdapter            
     */
    public function setProductPageAdapter($productPageAdapter)
    {
        $this->productPageAdapter = $productPageAdapter;
        return $this;
    }

    /**
     *
     * @param \Shop\Form\ProductCategoryForm $productCategoryForm            
     */
    public function setProductCategoryForm($productCategoryForm)
    {
        $this->productCategoryForm = $productCategoryForm;
        return $this;
    }

    /**
     *
     * @param \General\Service\UploadService $uploadService            
     */
    public function setUploadService($uploadService)
    {
        $this->uploadService = $uploadService;
        return $this;
    }

    /**
     *
     * @param field_type $bbminService            
     */
    public function setBbminService($bbminService)
    {
        $this->bbminService = $bbminService;
        return $this;
    }

    /**
     *
     * @param \General\Form\DropzoneForm $dropZoneForm            
     */
    public function setDropZoneForm($dropZoneForm)
    {
        $this->dropZoneForm = $dropZoneForm;
        return $this;
    }
}