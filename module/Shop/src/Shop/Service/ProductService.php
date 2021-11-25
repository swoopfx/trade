<?php

namespace Shop\Service;

use Doctrine\ORM\EntityManager;
use Laminas\Authentication\AuthenticationService;
use General\Service\GeneralService;
use Shop\Entity\Image;
use Shop\Entity\Product;
use Shop\Entity\ProductDescription;
use Shop\Entity\Category;
use Doctrine\Common\Collections\Collection;

/**
 *
 * @author otaba
 *        
 */
class ProductService
{

    const PRODUCT_STOCK_STATUS_IN_STOCK = 10;

    const PRODUCT_STOCK_STATUS_OUT_OF_STOCK = 30;

    const PRODUCT_STOCK_STATUS_PRE_ORDER = 50;

    const PRODUCT_STOCK_STATUS_2_3_DAYS = 60;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var AuthenticationService
     */
    private $auth;

    /**
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     */
    public function __construct()
    {

        // TODO - Insert your code here
    }

    public function getAllShopCategory()
    {
        $em = $this->entityManager;
        $category = $em->getRepository(Category::class)->findAll();
        return $category;
    }
    
    

    public function getCategorizeProductSnippet(int $categoryId)
    {
        $em = $this->entityManager;
        $products = $em->getRepository(Product::class)->findBy([
            "category" => $categoryId,
            "isPublished" => TRUE
        ], [
            "id" => "DESC"
        ], 8);

        return $products;
    }

    public static function generateProductUid()
    {
        return uniqid(time(), false);
    }

    /**
     * This get ProductEntity form the productUid
     *
     * @param string $productUid            
     * @return object|NULL|NULL
     */
    public function getProductEntity(string $productUid)
    {
        $em = $this->entityManager;
        if ($productUid != NULL) {

            $productEntity = $em->getRepository("Shop\Entity\Product")->findOneBy(array(
                "productUid" => $productUid
            ));

            return $productEntity;
        } else {
            return NULL;
        }
    }

    /**
     * Gets best sellers| amount of
     *
     * @return unknown|NULL
     */
    public function getShopDashboardBestSellers()
    {
        $em = $this->entityManager;
        $entity = $em->getRepository("Shop\Entity\Product")->findProductBestSeller();
        if ($entity != NULL) {
            return $entity;
        } else {
            return NULL;
        }
    }

    /**
     *
     * @param Product $data
     *            |
     * @return string
     */
    public static function noImageOnproduct($data)
    {
        if ($data == NULL) {
            return "";
        } else {
            if (is_array($data)) {
                return ($data["image"] != NULL ? $data["image"][0]["lowres"] : "/shop/images/no-image.png");
            } else {
                return ($data->getImage() != NULL ? $data->getImage()[0]->getLowres() : "/shop/images/no-image.png");
            }
        }
    }

    /**
     *
     * @param Product $data            
     * @return string|string|\Shop\Entity\the
     */
    public static function getProductPoints(Product $data)
    {
        if ($data == NULL) {
            return "";
        } else {
            return ($data->getPoints() != NULL ? $data->getPoints() : "");
        }
    }

    public static function getActivePrice($data)
    {
        if ($data == NULL) {
            return "";
        } else {
            if (is_array($data)) {

                if ($data["isDiscount"]) {
                    return $data["discount"]["price"]; // return discounted Price
                } else {
                    return $data["price"];
                }
            } else {
               
//                 return $data->getPrice();
                if ($data->getIsDiscount()) {
                    return $data->getDiscount()->getPrice();
                } else {
                    return $data->getPrice();
                }
            }
        }
    }
    
   

    // private static function

    /**
     *
     * @param Product $data            
     * @return string|string|\Shop\Entity\the
     */
    public static function getPointMinQuantity(Product $data)
    {
        if ($data == NULL) {
            return "";
        } else {
            return ($data->getPointMinQuantity() != NULL ? $data->getPointMinQuantity() : "");
        }
    }

    /**
     *
     * @param Product $data            
     * @return string|string|\Shop\Entity\the
     */
    public static function getProductSku(Product $data)
    {
        if ($data == NULL) {
            return "";
        } else {
            return ($data->getSku() == NULL ? "" : $data->getSku());
        }
    }

    /**
     *
     * @param Product $data            
     * @return string|string|\Shop\Entity\the
     */
    public static function getProductUid(Product $data)
    {
        if ($data == NULL) {
            return "";
        } else {
            return ($data->getProductUid() != NULL ? $data->getProductUid() : "");
        }
    }

    /**
     * Gets the name/Title of the product
     *
     * @param Product $data            
     * @return string|\Shop\Entity\the
     */
    public function getProductName(Product $data)
    {
        if ($data == NULL) {
            return "";
        } else {
            $em = $this->entityManager;
            /**
             *
             * @var ProductDescription $productDescriptionEntity
             */
            $productDescriptionEntity = $em->getRepository("Shop\Entity\ProductDescription")->findOneBy(array(
                "product" => $data->getId()
            ));
            if ($productDescriptionEntity != NULL) {
                return ($productDescriptionEntity->getProductName() != NULL ? $productDescriptionEntity->getProductName() : "");
            }
        }
    }

    /**
     * 
     * @param Product $data
     */
    public static function getProductNameStatic(Product $data)
    {
        return "KKKK";
//         if ($data == NULL) {
//             return "";
//         } else {
//             if(is_array($data)){
//                 return $data["productDescription"]["productName"];
//             }else{
//                 return $data->getProductDescription()->getProductName();
//             }
//         }
    }

    /**
     * This gets the price of the product
     *
     * @param Product $data            
     * @return string|string|mixed
     */
    public static function getProductPrice(Product $data)
    {
        if ($data == NULL) {
            return "";
        } else {
            return ($data->getPrice() != NULL ? ProductService::cleanPrice($data->getPrice()) : "");
        }
    }

    /**
     *
     * @param Product $data            
     * @return string|\Shop\Entity\the
     */
    public function getProductDescription(Product $data)
    {
        if ($data == NULL) {
        } else {
            $em = $this->entityManager;
            /**
             *
             * @var ProductDescription $productDescriptionEntity
             */
            $productDescriptionEntity = $em->getRepository("Shop\Entity\ProductDescription")->findOneBy(array(
                "product" => $data->getId()
            ));
            return ($productDescriptionEntity->getDescription() != NULL ? $productDescriptionEntity->getDescription() : "");
        }
    }

    public static function cleanPrice($data)
    {
        return str_replace(",", "", $data);
    }

    /**
     *
     * @return array|NULL
     */
    public function getMostRecentProduct()
    {
        $em = $this->entityManager;
        /**
         *
         * @var array $entity
         */
        $entity = $em->getRepository(Product::class)->findMostRecentProductsArray();
        if (count($entity) != 0) {
            return $entity;
        } else {
            return NULL;
        }
    }

    /**
     *
     * @return mixed|\Doctrine\DBAL\Driver\Statement|array|NULL
     */
    public function getHighPointProducts()
    {
        $em = $this->entityManager;
        $query = $em->createQueryBuilder()
            ->select("Max(h.points)")
            ->from("Shop\Entity\Product", "h")
            ->orderBy("h.points", "DESC")
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $query;
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
     * @param \Laminas\Authentication\AuthenticationService $auth            
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
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
}
