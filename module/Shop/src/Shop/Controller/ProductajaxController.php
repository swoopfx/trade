<?php
namespace Shop\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;
use General\Service\GeneralService;
use Shop\Entity\ProductAvailableSizes;
use Settings\Entity\Size;
use Shop\Service\CartService;
use Shop\Entity\Product;
use Shop\Entity\ProductRelated;
use Doctrine\ORM\Query;

/**
 *
 * @author otaba
 *        
 */
class ProductajaxController extends AbstractActionController
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     *
     * @var CartService
     */
    private $cartService;

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function indexAction()
    {
        return array();
    }
    /**
     * This is used to get related product of the specific product 
     * @return \Laminas\View\Model\JsonModel
     */
    public function getRelatedProductAction(){
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $param = $this->params()->fromRoute("id", NULL);
        if($param != NULL){
            $em = $this->entityManager;
            $repo = $em->getRepository(ProductRelated::class);
            $data = $repo->createQueryBuilder("pr")->select("pr")->where("pr.productId = :product")->setParameters([
                "product"=>$param
            ])->getQuery()->getResult(Query::HYDRATE_ARRAY);

            $jsonModel->setVariables([
                "data"=>$data
            ]);
            
        }
      
        return $jsonModel;
    }

    public function productdetailsAction()
    {
        $jsonModel = new JsonModel();
        $cartService = $this->cartService;
        // var_dump($cartService->getCartDetails());
        $jsonModel->setVariables([
            'data' => $cartService->getCartDetails(),
            'finalprice' => $cartService->getfinalprice()
        ]);
        return $jsonModel;
    }

    public function cartcountAction()
    {
        $jsonModel = new JsonModel();
        $cartService = $this->cartService;
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
        $jsonModel->setVariables([
            "data" => $cartService->getCartCount()
        ]);
        return $jsonModel;
    }

    /**
     * Adds an item to the cart
     * 
     * @return \Laminas\View\Model\JsonModel
     */
    public function addtocartAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $response = $this->getResponse();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            
            try {
                $content = json_decode($post['content']);
                
                $productuid = $post['productuid'];
                
                $productEntity = $em->getRepository(Product::class)->findOneBy([
                    "productUid" => $productuid
                ]);
                $cartService = $this->cartService;
                $cartService->setCart()
                    ->getCartItemService()
                    ->setCartItemContent($content)
                    ->setCartItemProduct($productEntity)
                    ->insertItem()
                    ->execute();
                ;
                
                $response->setStatusCode(201);
                $jsonModel->setVariables([
//                     'data' => $data
                ]);
            } catch (\Exception $e) {
                $response->setStatusCode(422);
                $jsonModel->setVariables([
                    'messages' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        } else {
            $response->getStatusCode(400);
            $jsonModel->setVariables([
                'messages' => "Access denied"
            ]);
        }
        return $jsonModel;
    }

    public function removefromcartAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            if ($post['itemid'] != null) {
                try {
                    $cartService = $this->cartService;
                    $cartService->setCart()
                        ->getCartItemService()
                        ->setCartItem($post['itemid'])
                        ->removeItem()
                        ->execute();
                    
                        $response->setStatusCode(204);
                        $this->flashmessenger()->addSuccessMessage("Successfully removed an item");
                } catch (\Exception $e) {
                    $response->setStatusCode(500);
                    $jsonModel->setVariables([
                        'messages' => "We could not remove this item"
                    ]);
                }
            }
        } else {
            $response->getStatusCode(400);
            $jsonModel->setVariables([
                'messages' => "Access denied"
            ]);
        }
        return $jsonModel;
    }

    public function sizeQuantityAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $sizeid = $this->params()->fromPost("size", NULL);
        $prooductid = $this->params()->fromPost("product", NULL);
        if ($sizeid == NULL) {
            $response->setStatusCode(400);
            $jsonModel->setVariables([
                "messages" => "Absent identifier"
            ]);
        } else {
            $em = $this->entityManager;
            $data = $em->getRepository(ProductAvailableSizes::class)->findOneBy([
                "sizes" => $sizeid,
                "product" => $prooductid
            ]);
            
            $jsonModel->setVariable('data', $data->getAvalaibleQuantity());
            $response->setStatusCode(200);
        }
        
        return $jsonModel;
    }

    public function getsizenameAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $id = $this->params()->fromRoute('id', NULL);
        /**
         *
         * @var Size $data
         */
        $data = $em->find(Size::class, $id);
        $jsonModel->setVariable('data', $data->getSize());
        return $jsonModel;
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
     * @param \Shop\Service\CartService $cartService            
     */
    public function setCartService($cartService)
    {
        $this->cartService = $cartService;
        return $this;
    }
}

