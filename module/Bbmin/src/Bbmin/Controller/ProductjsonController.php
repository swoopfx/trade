<?php
namespace Bbmin\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Bbmin\Service\BbminService;
use Doctrine\ORM\EntityManager;
use Laminas\Session\Container;
use Shop\Entity\Product;
use Laminas\Http\Response;
use General\Service\UploadService;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\File\UploadFile;
use Settings\Entity\GarmentType;
use Shop\Entity\ProductFeatures;
use Settings\Entity\ProductFeatureType;
use Shop\Form\ProductForm;
use Shop\Service\ProductService;
use Shop\Entity\ProductAttribute;
use General\Service\GeneralService;
use Shop\Form\Fieldset\ProductFieldsetInputFilter;
use Shop\Entity\Category;
use Settings\Entity\Size;
use Shop\Entity\ProductDescription;
use Shop\Entity\StockStatus;
use Settings\Entity\Tax;
use Settings\Entity\Sex;
use Shop\Entity\Image;
use Shop\Entity\ProductAvailableSizes;

/**
 *
 * Handles all json call related to the product
 *
 * @author otaba
 *        
 */
class ProductjsonController extends AbstractActionController
{

    /**
     *
     * @var BbminService
     */
    private $bbminService;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var Container
     */
    private $addProductSession;

    /**
     *
     * @var UploadService
     */
    private $uploadService;

    /**
     *
     * @var ProductForm
     */
    private $productForm;

    /**
     *
     * @var ProductFieldsetInputFilter
     */
    private $productInputFilter;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function publishAction()
    {
        $em = $this->entityManager;
        $addProductSession = $this->bbminService->getAddProductSession();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $jsonModel = new JsonModel();
        if ($request->isPut()) {
            $rawData = file_get_contents("php://input");
            $data = json_decode($rawData, TRUE);
            /**
             *
             * @var Product $productEntity
             */
            
            $productEntity = $em->find(Product::class, $addProductSession->productid);
            $productEntity->setIsPublished($data["state"])->setUpdatedOn(new \DateTime());
            $em->persist($productEntity);
            $em->flush();
            $response->setStatusCode(Response::STATUS_CODE_201);
            $jsonModel->setVariable("state", $productEntity->getIsPublished());
        }
        return $jsonModel;
    }

    public function getProductStateAction()
    {
        $em = $this->entityManager;
        $addProductSession = $this->bbminService->getAddProductSession();
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $request = $this->getRequest();
        if ($addProductSession->productUid != NULL) {
            /**
             *
             * @var Product $productEntity
             */
            $productEntity = $em->getRepository(Product::class)->findOneBy([
                "productUid" => $addProductSession->productUid
            ]);
            
            $response->setStatusCode(Response::STATUS_CODE_200);
            $jsonModel->setVariable("state", $productEntity->getIsPublished());
        }
        return $jsonModel;
    }

    public function createProductAction()
    {
        $em = $this->entityManager;
        $jsonModel = new JsonModel();
        $addProductSession = $this->bbminService->getAddProductSession();
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $productEntity = new Product();
            // $post = json_decode(file_get_contents("php://input"));
            
            // var_dump($data);
            $data = GeneralService::standard_object_to_array($post);
            // $productForm = $this->productForm;
            
            // $productForm->bind($productEntity);
            // $productForm->setData($data);
            
            $post = $this->params()->fromPost();
            // var_dump($post);
            
            $productInputFilter = $this->productInputFilter;
            
            $productInputFilter->setData($post);
            
            $productInputFilter->setData($post);
            if ($productInputFilter->isValid()) {
                // $sizesArray = explode(",", $post["availableSizes"]);
                $validData = $productInputFilter->getValues();
                // var_dump($post["metaKeyword"]);
                // var_dump($validData["metaKeyword"]);
                try {
                    $sizeAndQuantityObject = json_decode($post['sizeAnQuantity']);
                    // var_dump($sizeAndQuantityObject);
                    if (is_object($addProductSession->features) || is_array($addProductSession->features)) {
                        if (count($addProductSession->features) > 0) {
                            foreach ($addProductSession->features as $feature) {
                                $productFeature = new ProductFeatures();
                                $productFeature->setCreatedOn(new \DateTime())
                                    ->setFeatureType($em->find("Settings\Entity\ProductFeatureType", $feature["type"]))
                                    ->setFeaturInfo($feature["info"])
                                    ->setProduct($productEntity);
                                
                                $em->persist($productFeature);
                            }
                        }
                    }
                    if (is_object($addProductSession->attributes) || is_array($addProductSession->attributes)) {
                        if (count($addProductSession->attributes) > 0) {
                            
                            foreach ($addProductSession->attributes as $attribute) {
                                $productAttribute = new ProductAttribute();
                                $productAttribute->setAttributeName($attribute["name"])
                                    ->setAttributetext($attribute["description"])
                                    ->setProduct($productEntity)
                                    ->setCreatedOn(new \DateTime());
                                $em->persist($productAttribute);
                            }
                        }
                    }
                    
                    if (count($sizeAndQuantityObject) > 0) {
                        foreach ($sizeAndQuantityObject as $sq) {
                            $productSelectedSizes = new ProductAvailableSizes();
                            $productSelectedSizes->setAvalaibleQuantity($sq->quant)
                                ->setSizes($em->find(Size::class, $sq->siz))
                                ->setCreatedOn(new \DateTime())
                                ->setProduct($productEntity);
                            $em->persist($productSelectedSizes);
                        }
                    }
                    
                    $productDescriptionEntity = new ProductDescription();
                    $productDescriptionEntity->setProductName($validData["productName"])
                        ->setDescription($validData["description"])
                        ->setMetaDescription($validData["metaDescription"])
                        ->setProduct($productEntity)
                        ->setMetaTitle($validData["metaTitle"])
                        ->setMetaKeyword($validData["metaKeyword"]);
                    
                    // var_dump($validData["garmentType"]);
                    $productEntity->setCreatedOn(new \DateTime())
                        ->setCategory($em->find(Category::class, $validData['category']))
                        ->setGarmentType($em->find(GarmentType::class, $validData["garmentType"]))
                        ->setSku($validData["sku"])
                        ->
                    // ->setQuantity($post["quantity"])
                    setPrice($validData["price"])
                        ->setStockStatus($em->find(StockStatus::class, $post["stockStatus"]))
                        ->setIsShipping(GeneralService::string2Booleean($post["isShipping"]))
                        ->setIsDiscount(GeneralService::string2Booleean($post["isDiscount"]))
                        ->
                    // ->setGarmentSex($em->find(Sex::class, $post['sex']))
                    setPoints($validData["points"])
                        ->setPointMinQuantity($validData["pointMinQuantity"])
                        ->setTax($em->find(Tax::class, $post["tax"]))
                        ->setDateAvailable(($post["dateAvailable"] == "" ? new \DateTime() : \DateTime::createFromFormat("Y-m-d", $post["dateAvailable"])))
                        ->setWeight($validData["weight"])
                        ->setHeight($validData["height"])
                        ->setLength($validData["length"])
                        ->setWidth($validData["width"])
                        ->setSubtract(GeneralService::string2Booleean($post['subtract']))
                        ->setMinimum($validData["minimum"])
                        ->setProductUid(ProductService::generateProductUid())
                        ->setIsPublished(FALSE);
                    
                    $em->persist($productEntity);
                    $em->persist($productDescriptionEntity);
                    $em->flush();
                    $addProductSession->productid = $productEntity->getId();
                    // var_dump($productEntity->getProductUid());
                    $response->setStatusCode(Response::STATUS_CODE_201);
                    // $jsonModel->setVariable("id", $productEntity->getId());
                    $jsonModel->setVariable("uid", $productEntity->getProductUid());
                    // $jsonModel->setVariable("name", $productEntity->getProductDescription()
                    //     ->getProductName());
                    // $jsonModel->setVariable("sku", $productEntity->getSku());
                    return $jsonModel;
                } catch (\Exception $e) {
                    // return with validation error
                    $response->setStatusCode(Response::STATUS_CODE_422);
                    $jsonModel->setVariables([
                        "message" => $e->getMessage(),
                        "trce" => $e->getTrace()
                    ]);
                }
            } else {
                // return with validation error
                $response->setStatusCode(Response::STATUS_CODE_422);
                $jsonModel->setVariables([
                    "message" => $productInputFilter->getMessages()
                ]);
            }
        }
        
        return $jsonModel;
    }

    /**
     * Updates active product Description Session
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function updateProductDescAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $addProductSession = $this->bbminService->getAddProductSession();
        }
        return $jsonModel;
    }

    public function getGarmentTypeAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $response = $this->getResponse();
        $id = $this->params()->fromQuery("id", NULL);
        if ($id != NULL) {
            
            $garmentTypeArray = $em->getRepository(GarmentType::class)->garmenTTypeArray(strip_tags($id));
            $response->setStatusCode(Response::STATUS_CODE_200);
            $jsonModel->setVariables([
                "type" => $garmentTypeArray
            ]);
        }
        return $jsonModel;
    }

    public function getGarmentSizeAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $response = $this->getResponse();
        $id = $this->params()->fromQuery("sexid", NULL);
        $matid = $this->params()->fromQuery("matid", NULL);
        if ($id != NULL) {
            
            $garmenSize = $em->getRepository(Size::class)->getGarmentSizeArray(strip_tags($id), strip_tags($matid));
            
            // $garmentTypeArray = $em->getRepository(GarmentType::class)->garmenTTypeArray(strip_tags($id));
            $response->SetStatusCode(Response::STATUS_CODE_200);
            $jsonModel->setVariables([
                "size" => $garmenSize
            ]);
        }
        return $jsonModel;
    }

    public function skuvalidationAction()
    {
        $jsonModel = new JsonModel();
        $sku = $this->params()->fromQuery("sku");
        $em = $this->entityManager;
        $productEntity = $em->getRepository(Product::class)->findOneBy([
            "sku" => strip_tags($sku)
        ]);
        $response = $this->getResponse();
        $response->setStatusCode(Response::STATUS_CODE_200);
        
        if ($productEntity == NULL) {
            $jsonModel->setVariables([
                "sku" => 0
            ]);
        } else {
            $jsonModel->setVariables([
                "sku" => 1
            ]);
        }
        return $jsonModel;
    }

    public function getproductFeatureAction()
    {
        $addProductSession = $this->bbminService->getAddProductSession();
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        if ($addProductSession->features != NULL) {
            // print_r($addProductSession->features);
            // var_dump($addProductSession->features);
            $response->setStatusCode(Response::STATUS_CODE_200);
            $jsonModel->setVariables([
                "response" => $addProductSession->features
            ]);
        }
        
        return $jsonModel;
    }

    public function getproductAttributesAction()
    {
        $addProductSession = $this->bbminService->getAddProductSession();
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        if ($addProductSession->attributes != NULL) {
            $response->setStatusCode(Response::STATUS_CODE_200);
            $jsonModel->setVariables([
                "response" => $addProductSession->attributes
            ]);
        }
        return $jsonModel;
    }

    /**
     * Uploads an Image to Product Entity
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function uploadProductImageAction()
    {
        $em = $this->entityManager;
        $addProductSession = $this->bbminService->getAddProductSession();
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $request = $this->getRequest();
        try {
            
            if ($request->isPost()) {
                $file = $request->getFiles()->toArray();
                
                $validator = new UploadFile();
                
                if ($validator->isValid($file["image"])) {
                    $imageEntity = $this->uploadService->upload($file["image"]);
                    /**
                     *
                     * @var Product $productEntity
                     */
                    $productEntity = $em->find(Product::class, $addProductSession->productid);
                    
                    $productEntity->addImage($imageEntity);
                    $em->persist($imageEntity);
                    $em->persist($productEntity);
                    
                    $em->flush();
                    
                    $response->setStatusCode(Response::STATUS_CODE_201);
                } else {}
            } else {
                $response->setStatusCode(Response::STATUS_CODE_423);
                $jsonModel->setVariables(array(
                    "message" => "Not Authorized"
                ));
            }
        } catch (\Exception $e) {
            $response->setStatusCode(Response::STATUS_CODE_413);
            $jsonModel->setVariables(array(
                "message" => $e->getMessage()
            ));
        }
        
        return $jsonModel;
    }

    /**
     * Gets A specific Image
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function getImageAction()
    {
        $em = $this->entityManager;
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $imageId = $this->params()->fromRoute("id");
        if ($imageId != NULL) {
            /**
             *
             * @var Image $imageEntity
             */
            $imageEntity = $em->find(Image::class, $imageId);
            $response->SetStatusCode(Response::STATUS_CODE_200);
            $jsonModel->setVariable('url', $imageEntity->getLowres());
        }
        
        return $jsonModel;
    }

    public function removeimageAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $addProductSession = $this->bbminService->getAddProductSession();
        $response = $this->getResponse();
        $request = $this->getRequest();
        if ($request->isPut()) {
            $rawData = file_get_contents("php://input");
            
            $data = json_decode($rawData, TRUE);
            /**
             *
             * @var Product $productEntity
             */
            
            $productEntity = $em->find(Product::class, $addProductSession->productid);
            $productEntity->removeImage($em->find(Image::class, $data["imageId"]));
            
            $em->persist($productEntity);
            $em->flush();
            $response->setStatusCode(Response::STATUS_CODE_204);
        } else {
            $response->setStatusCode(Response::STATUS_CODE_423);
        }
        return $jsonModel;
    }

    /**
     * return the a list of images associated to this prouct
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function productimagesAction()
    {
        $em = $this->entityManager;
        $productUid = $this->params()->fromRoute("id", NULL) ?? $this->bbminService->getAddProductSession()->productUid; // the productUid
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        if ($productUid == NULL) {
            $response->setStatusCode(Response::STATUS_CODE_422);
            return $jsonModel->setVariables([
                "messages" => "Absent Identifier"
            ]);
        } else {
            /**
             *
             * @var Product $productEntity
             */
            $imageArray = $em->getRepository(Product::class)->findProductsImageArray($productUid);
            // var_dump(get_object_vars($productEntity->getImage()));
            if ($imageArray != NULL) {
                // $imageArray = $productEntity->getImage()->getValues();
                $response->setStatusCode(Response::STATUS_CODE_200);
                $jsonModel->setVariables($imageArray[0]["image"]);
            }
        }
        return $jsonModel;
    }

    public function addproductfeatureAction()
    {
        $em = $this->entityManager;
        
        $addProductSession = $this->bbminService->getAddProductSession();
        
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            // $data = $request->getPost();
            $data = json_decode(file_get_contents("php://input"), TRUE);
            /**
             * TODO
             * keys are
             * type : integer
             * info : string unstripped and unvlidated
             * Validate Data
             */
            
            /**
             *
             * @var ProductFeatureType $feature
             */
            $feature = $em->find(ProductFeatureType::class, $data["type"]);
            $data["typeName"] = $feature->getType();
            if (is_array($addProductSession->features)) {
                array_push($addProductSession->features, $data);
            } else {
                $addProductSession->features = array(
                    $data
                );
            }
            
            $response->setStatusCode(Response::STATUS_CODE_201);
            $jsonModel = new JsonModel([
                "response" => $addProductSession->features
            ]);
        } else {
            $response->setStatusCode(Response::STATUS_CODE_500);
        }
        
        return $jsonModel;
    }

    public function addproductattributesAction()
    {
        $em = $this->entityManager;
        
        $addProductSession = $this->bbminService->getAddProductSession();
        
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $data = $request->getPost();
            // $data = json_decode(file_get_contents("php://input"), TRUE);
            if (is_array($addProductSession->attributes)) {
                array_push($addProductSession->attributes, $data);
            } else {
                $addProductSession->attributes = array(
                    $data
                );
            }
            
            $response->setStatusCode(Response::STATUS_CODE_201);
            $jsonModel = new JsonModel([
                "response" => $addProductSession->attributes
            ]);
        } else {
            $response->setStatusCode(Response::STATUS_CODE_500);
        }
        
        return $jsonModel;
    }

    public function removeproductFeatureAction()
    {
        $addProductSession = $this->bbminService->getAddProductSession();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $jsonModel = new JsonModel();
        if ($request->isPut()) {
            $rawData = file_get_contents("php://input");
            
            $data = json_decode($rawData, TRUE);
            unset($addProductSession->features[$data["key"]]);
            
            $response->setStatusCode(Response::STATUS_CODE_200);
        } else {
            $response->setStatusCode(Response::STATUS_CODE_500);
        }
        
        return $jsonModel;
    }

    // public function addproductattributesAction()
    // {
    // $addProductSession = $this->bbminService->getAddProductSession();
    // $request = $this->getRequest();
    // if ($request->isPost()) {}
    // $jsonModel = new JsonModel();
    // return $jsonModel;
    // }
    public function uploadproductimagesAction()
    {
        $em = $this->entityManager;
        $addProductSession = $this->bbminService->getAddProductSession();
        if (isset($addProductSession)) {
            if ($addProductSession->productid != NULL) {
                $request = $this->getRequest();
                if ($request->isPost() || $request->isXmlHttpRequest()) {
                    $files = $this->params()->fromFiles('file');
                    /**
                     *
                     * @var Product $productEntity
                     */
                    $productEntity = $em->find(Product::class, $addProductSession->productid);
                    $uploadService = $this->uploadService;
                    try {
                        $imageEntity = $uploadService->upload($files);
                        // $em->persist($imageEntity);
                        
                        $productEntity->addImage($imageEntity);
                        $em->persist($productEntity);
                        $em->flush();
                        
                        return new JsonModel(array(
                            "status" => "200",
                            "message" => "Upload Successfull"
                        ));
                    } catch (\Exception $e) {}
                }
            }
        } else {
            return new JsonModel(array(
                "status" => "0",
                "message" => "Upload Error"
            ));
        }
        $jsonModel = new JsonModel();
        return $jsonModel;
    }

    public function removeproductattributesAction()
    {
        $jsonModel = new JsonModel();
        return $jsonModel;
    }

    public function productCategorydependent()
    {}

    /**
     *
     * @param \Bbmin\Service\BbminService $bbminService            
     */
    public function setBbminService($bbminService)
    {
        $this->bbminService = $bbminService;
        return $this;
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
     * @param \Laminas\Session\Container $addProductSession            
     */
    public function setAddProductSession($addProductSession)
    {
        $this->addProductSession = $addProductSession;
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
     * @param \Shop\Form\ProductForm $productForm            
     */
    public function setProductForm($productForm)
    {
        $this->productForm = $productForm;
        return $this;
    }

    /**
     *
     * @param \Shop\Form\Fieldset\ProductFieldsetInputFilter $productInputFilter            
     */
    public function setProductInputFilter($productInputFilter)
    {
        $this->productInputFilter = $productInputFilter;
        return $this;
    }
}

