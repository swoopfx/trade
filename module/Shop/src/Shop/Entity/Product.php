<?php
namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;
use Settings\Entity\WeightClass;
use Shop\Entity\Image;
use Doctrine\Common\Collections\ArrayCollection;
use Settings\Entity\GarmentType;
use Doctrine\Common\Collections\Collection;
use Settings\Entity\Tax;
use Settings\Entity\Size;
use Settings\Entity\Sex;

/**
 * Product
 *
 * @ORM\Table(name="product", indexes={@ORM\Index(name="id", columns={"product_uid", "points", "price", "sku"})})
 * @ORM\Entity(repositoryClass="Shop\Entity\Repository\ProductRepository")
 */
class Product
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="ProductDescription", mappedBy="product", cascade={"persist", "remove"})
     *
     * @var ProductDescription
     */
    private $productDescription;

    /**
     * @ORM\Column(name="product_uid", type="string", nullable=false);
     *
     * @var string
     */
    private $productUid;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     *
     * @var Category
     */
    private $category;

    /**
     * This is dependent on the Category
     * @ORM\ManyToOne(targetEntity="Settings\Entity\GarmentType")
     *
     * @var GarmentType
     */
    private $garmentType;

    /**
     * What Sex usesthe garment
     * @ORM\ManyToOne(targetEntity="Settings\Entity\Sex")
     *
     * @var Sex
     *
     */
    private $garmentSex;

    // /**
    // * @ORM\ManyToMany(targetEntity="Settings\Entity\Size")
    // * @ORM\JoinTable(name="product_availaible_sizes",
    // * joinColumns={@ORM\JoinColumn(name="product", referencedColumnName="id")},
    // * inverseJoinColumns={@ORM\JoinColumn(name="sizes", referencedColumnName="id")}
    // * )
    // *
    // * @var Size
    // * @var Collection
    // */
    /**
     * @ORM\OneToMany(targetEntity="Shop\Entity\ProductAvailableSizes", mappedBy="product", fetch="EXTRA_LAZY")
     *
     * @var Collection
     */
    private $availaibleSizes;

    /**
     * @ORM\OneToMany(targetEntity="ProductAttribute", mappedBy="product", cascade={"persist", "remove"})
     *
     * @var Collection
     */
    private $productAttributes;

    /**
     * These are fetures like Color, Fabric Type, etc
     * @ORM\OneToMany(targetEntity="ProductFeatures", mappedBy="product", cascade={"persist", "remove"})
     *
     * @var Collection
     */
    private $productFeatures;

    /**
     * The SKU value, a unique identifier for the product
     *
     * @var string @ORM\Column(name="sku", type="string", length=64, nullable=false, unique=true)
     */
    private $sku;

    /**
     *
     * @var string @ORM\Column(name="upc", type="string", length=12, nullable=true)
     */
    private $upc;

    /**
     *
     * @var string @ORM\Column(name="ean", type="string", length=14, nullable=true)
     */
    private $ean;

    /**
     *
     * @var string @ORM\Column(name="jan", type="string", length=13, nullable=true)
     */
    private $jan;

    /**
     *
     * @var string @ORM\Column(name="mpn", type="string", length=64, nullable=true)
     */
    private $mpn;

    /**
     *
     * @var string @ORM\Column(name="location", type="string", length=128, nullable=true)
     */
    private $location;

    /**
     * This is the availaible quiantity of the product
     *
     * @var int @ORM\Column(name="quantity", type="integer", nullable=true, options={"default"="0"})
     */
    private $quantity = '0';

    /**
     *
     * @var StockStatus @ORM\ManyToOne(targetEntity="Shop\Entity\StockStatus")
     */
    private $stockStatus;

    /**
     * FIXME - refer to the upload/document entity
     * 
     * @ORM\ManyToMany(targetEntity="Shop\Entity\Image")
     * @ORM\JoinTable(name="product_images", joinColumns={@ORM\JoinColumn(name="product", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="image", referencedColumnName="id")})
     *
     * @var Collection
     */
    private $image;

    /**
     * Defines if shippinf of the product is permited/required
     *
     * @var bool @ORM\Column(name="is_shipping", type="boolean", nullable=false, options={"default"="1"})
     */
    private $isShipping = true;

    /**
     * The default price of the product
     *
     * @var string @ORM\Column(name="price", type="string", nullable=false, options={"default"="0.00"})
     */
    private $price = '0.0000';

    /**
     * Defines if there is a discount on this product
     * if so the discounted prices would be used
     * @ORM\Column(name="is_discount", type="boolean", nullable=true)
     *
     * @var boolean
     */
    private $isDiscount;

    /**
     * @ORM\OneToOne(targetEntity="ProductDiscount", mappedBy="product", cascade={"persist", "remove"})
     *
     * @var ProductDiscount
     */
    private $discount;

    /**
     * This is the amount of points attributed to the product/ mainly for credit and bonus purposes
     *
     * @var int @ORM\Column(name="points", type="integer", nullable=true)
     */
    private $points = '0';

    /**
     * This is the minimum quantity required for point based reward to be activated
     * @ORM\Column(name="ponts_min_quantity", type="string", nullable=true, options={"default"="0"})
     *
     * @var string
     */
    private $pointMinQuantity = "0";

    /**
     * @ORM\ManyToOne(targetEntity="Settings\Entity\Tax")
     *
     * @var Tax
     */
    private $tax;

    /**
     *
     * @var \DateTime @ORM\Column(name="date_available", type="datetime", nullable=true)
     */
    private $dateAvailable;

    /**
     *
     * @var string @ORM\Column(name="weight", type="decimal", precision=15, scale=8, nullable=true, options={"default"="0.00000000"})
     */
    private $weight = '0.00000000';

    // /**
    // * @var WeightClass
    // *
    // * @ORM\ManyToOne(targetEntity="Settings\Entity\WeightClass")
    // */
    // private $weightClassId = '0';
    
    /**
     *
     * @var string @ORM\Column(name="length", type="string", nullable=true, options={"default"="0.00000000"})
     */
    private $length = '0.00000000';

    /**
     *
     * @var string @ORM\Column(name="width", type="string", nullable=true, options={"default"="0.00000000"})
     */
    private $width = '0.00000000';

    /**
     *
     * @var string @ORM\Column(name="height", type="string", nullable=true, options={"default"="0.00000000"})
     */
    private $height = '0.00000000';

    // /**
    // *
    // * @var int @ORM\Column(name="length_class_id", type="integer", nullable=true)
    // */
    // private $lengthClassId = '0';
    
    /**
     * Meaning for every acquisition a sbtraction is made from the total quantity
     *
     * @var bool @ORM\Column(name="subtract", type="boolean", nullable=true, options={"default"="1"})
     */
    private $subtract = true;

    /**
     * This is the minimum quantity that can be purchased
     *
     * @var int @ORM\Column(name="minimum", type="integer", nullable=true, options={"default"="1"})
     */
    private $minimum = '1';

    // /**
    // *
    // * @var int @ORM\Column(name="sort_order", type="integer", nullable=false)
    // */
    // private $sortOrder = '0';
    
    // /**
    // *
    // * @var bool @ORM\Column(name="status", type="boolean", nullable=false)
    // */
    // private $status = '0';
    
    // /**
    // * Triggered for upon view made
    // *
    // * @var int @ORM\Column(name="viewed", type="integer", nullable=false)
    // */
    // private $viewed = '0';
    
    /**
     *
     * @var \DateTime @ORM\Column(name="created_on", type="datetime", nullable=false)
     */
    private $createdOn;

    /**
     *
     * @var \DateTime @ORM\Column(name="updated_on", type="datetime", nullable=false)
     */
    private $updatedOn;

    /**
     * Only published products would be accessible in the view
     *
     * @ORM\Column(name="is_published", type="boolean", nullable=true)
     *
     * @var boolean
     */
    private $isPublished;

    /**
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="relatedProducts")
     */
    private $productRelated;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Product", inversedBy="productRelated")
     * @ORM\JoinTable(name="related_product",
     * joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="related_id", referencedColumnName="id")}
     * )
     * 
     * @var Collection
     */
    private $relatedProducts;

    public function __construct()
    {
        $this->productAttributes = new ArrayCollection();
        $this->availaibleSizes = new ArrayCollection();
        $this->productFeatures = new ArrayCollection();
        $this->image = new ArrayCollection();
        $this->relatedProducts = new ArrayCollection();
    }

    /**
     *
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return the $productDescription
     */
    public function getProductDescription()
    {
        return $this->productDescription;
    }

    /**
     *
     * @return the $productUid
     */
    public function getProductUid()
    {
        return $this->productUid;
    }

    /**
     *
     * @return the $category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     *
     * @return the $garmentType
     */
    public function getGarmentType()
    {
        return $this->garmentType;
    }

    /**
     *
     * @return the $availableSizes
     */
    public function getAvailaibleSizes()
    {
        return $this->availaibleSizes;
    }

    /**
     *
     * @return the $productAttributes
     */
    public function getProductAttributes()
    {
        return $this->productAttributes;
    }

    /**
     *
     * @return the $productFeatures
     */
    public function getProductFeatures()
    {
        return $this->productFeatures;
    }

    /**
     *
     * @return the $sku
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     *
     * @return the $upc
     */
    public function getUpc()
    {
        return $this->upc;
    }

    /**
     *
     * @return the $ean
     */
    public function getEan()
    {
        return $this->ean;
    }

    /**
     *
     * @return the $jan
     */
    public function getJan()
    {
        return $this->jan;
    }

    /**
     *
     * @return the $mpn
     */
    public function getMpn()
    {
        return $this->mpn;
    }

    /**
     *
     * @return the $location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     *
     * @return the $quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     *
     * @return the $stockStatus
     */
    public function getStockStatus()
    {
        return $this->stockStatus;
    }

    /**
     *
     * @return the $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     *
     * @return the $isShipping
     */
    public function getIsShipping()
    {
        return $this->isShipping;
    }

    /**
     *
     * @return the $price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     *
     * @return the $isDiscount
     */
    public function getIsDiscount()
    {
        return $this->isDiscount;
    }

    /**
     *
     * @return the $points
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     *
     * @return the $pointMinQuantity
     */
    public function getPointMinQuantity()
    {
        return $this->pointMinQuantity;
    }

    /**
     *
     * @return the $tax
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     *
     * @return the $dateAvailable
     */
    public function getDateAvailable()
    {
        return $this->dateAvailable;
    }

    /**
     *
     * @return the $weight
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     *
     * @return the $length
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     *
     * @return the $width
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     *
     * @return the $height
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     *
     * @return the $lengthClassId
     */
    public function getLengthClassId()
    {
        return $this->lengthClassId;
    }

    /**
     *
     * @return the $subtract
     */
    public function getSubtract()
    {
        return $this->subtract;
    }

    /**
     *
     * @return the $minimum
     */
    public function getMinimum()
    {
        return $this->minimum;
    }

    /**
     *
     * @return the $sortOrder
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     *
     * @return the $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     *
     * @return the $viewed
     */
    public function getViewed()
    {
        return $this->viewed;
    }

    /**
     *
     * @return the $createdOn
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     *
     * @return the $updatedOn
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     *
     * @param number $id            
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @param \Shop\Entity\ProductDescription $productDescription            
     */
    public function setProductDescription($productDescription)
    {
        $this->productDescription = $productDescription;
        $productDescription->setProduct($this);
        return $this;
    }

    /**
     *
     * @param string $productUid            
     */
    public function setProductUid($productUid)
    {
        $this->productUid = $productUid;
        return $this;
    }

    /**
     *
     * @param \Shop\Entity\Category $category            
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     *
     * @param \Settings\Entity\GarmentType $garmentType            
     */
    public function setGarmentType($garmentType)
    {
        $this->garmentType = $garmentType;
        return $this;
    }

    /**
     *
     * @param Size $availableSizes            
     */
    public function addAvailaibleSizes($availableSizes)
    {
        if (! $this->availaibleSizes->contains($availableSizes)) {
            $this->availaibleSizes[] = $availableSizes;
        }
        return $this;
    }

    public function removeAvailaibleSizes($availableSizes)
    {
        if (! $this->availaibleSizes->contains($availableSizes)) {
            $this->availaibleSizes->add($availableSizes);
        }
        return $this;
    }

    // /**
    // *
    // * @param \Doctrine\Common\Collections\Collection $availableSizes
    // */
    // public function setAvailableSizes($availableSizes)
    // {
    // $this->availableSizes = $availableSizes;
    // return $this;
    // }
    
    /**
     *
     * @param \Doctrine\Common\Collections\Collection $productAttributes            
     */
    public function setProductAttributes($productAttributes)
    {
        $this->productAttributes = $productAttributes;
        return $this;
    }

    public function addProductAttributes($productAttributes)
    {
        if (! $this->productAttributes->contains($productAttributes)) {
            $this->productAttributes[] = $productAttributes;
        }
        return $this;
    }

    public function removeProductAttributes($productAttributes)
    {
        if ($this->productAttributes->contains($productAttributes)) {
            $this->productAttributes->removeElement($productAttributes);
        }
        return $this;
    }

    public function addProductFeatures($productFeatures)
    {
        if (! $this->productFeatures->contains($productFeatures)) {
            $this->productFeatures->add($productFeatures);
        }
        return $this;
    }

    public function removeProductFeatures($productFeatures)
    {
        if ($this->productFeatures->contains($productFeatures)) {
            $this->productFeatures->removeElement($productFeatures);
        }
        return $this;
    }

    // /**
    // *
    // * @param \Doctrine\Common\Collections\Collection $productFeatures
    // */
    // public function setProductFeatures($productFeatures)
    // {
    // $this->productFeatures = $productFeatures;
    // return $this;
    // }
    
    /**
     *
     * @param string $sku            
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
        return $this;
    }

    /**
     *
     * @param string $upc            
     */
    public function setUpc($upc)
    {
        $this->upc = $upc;
        return $this;
    }

    /**
     *
     * @param string $ean            
     */
    public function setEan($ean)
    {
        $this->ean = $ean;
        return $this;
    }

    /**
     *
     * @param string $jan            
     */
    public function setJan($jan)
    {
        $this->jan = $jan;
        return $this;
    }

    /**
     *
     * @param string $mpn            
     */
    public function setMpn($mpn)
    {
        $this->mpn = $mpn;
        return $this;
    }

    /**
     *
     * @param string $location            
     */
    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    /**
     *
     * @param number $quantity            
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     *
     * @param \Shop\Entity\StockStatus $stockStatus            
     */
    public function setStockStatus($stockStatus)
    {
        $this->stockStatus = $stockStatus;
        return $this;
    }

    // /**
    // *
    // * @param \Shop\Entity\Image $image
    // */
    // public function setImage($image)
    // {
    // $this->image = $image;
    // return $this;
    // }
    public function addImage(Image $image)
    {
        if (! $this->image->contains($image)) {
            $this->image[] = $image;
        }
        return $this;
    }

    public function removeImage(Image $image)
    {
        if ($this->image->contains($image)) {
            $this->image->removeElement($image);
        }
    }

    /**
     *
     * @param boolean $isShipping            
     */
    public function setIsShipping($isShipping)
    {
        $this->isShipping = $isShipping;
        return $this;
    }

    /**
     *
     * @param string $price            
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     *
     * @param boolean $isDiscount            
     */
    public function setIsDiscount($isDiscount)
    {
        $this->isDiscount = $isDiscount;
        return $this;
    }

    /**
     *
     * @param number $points            
     */
    public function setPoints($points)
    {
        $this->points = $points;
        return $this;
    }

    /**
     *
     * @param string $pointMinQuantity            
     */
    public function setPointMinQuantity($pointMinQuantity)
    {
        $this->pointMinQuantity = $pointMinQuantity;
        return $this;
    }

    /**
     *
     * @param \Settings\Entity\Tax $tax            
     */
    public function setTax($tax)
    {
        $this->tax = $tax;
        return $this;
    }

    /**
     *
     * @param DateTime $dateAvailable            
     */
    public function setDateAvailable($dateAvailable)
    {
        $this->dateAvailable = $dateAvailable;
        return $this;
    }

    /**
     *
     * @param string $weight            
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     *
     * @param string $length            
     */
    public function setLength($length)
    {
        $this->length = $length;
        return $this;
    }

    /**
     *
     * @param string $width            
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     *
     * @param string $height            
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     *
     * @param number $lengthClassId            
     */
    public function setLengthClassId($lengthClassId)
    {
        $this->lengthClassId = $lengthClassId;
        return $this;
    }

    /**
     *
     * @param boolean $subtract            
     */
    public function setSubtract($subtract)
    {
        $this->subtract = $subtract;
        return $this;
    }

    /**
     *
     * @param number $minimum            
     */
    public function setMinimum($minimum)
    {
        $this->minimum = $minimum;
        return $this;
    }

    /**
     *
     * @param number $sortOrder            
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    /**
     *
     * @param boolean $status            
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     *
     * @param number $viewed            
     */
    public function setViewed($viewed)
    {
        $this->viewed = $viewed;
        return $this;
    }

    /**
     *
     * @param DateTime $createdOn            
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        $this->updatedOn = $createdOn;
        return $this;
    }

    /**
     *
     * @param DateTime $updatedOn            
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;
        return $this;
    }

    /**
     *
     * @return the $discount
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     *
     * @return the $isPublished
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     *
     * @param \Shop\Entity\ProductDiscount $discount            
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     *
     * @param boolean $isPublished            
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;
        return $this;
    }

    /**
     *
     * @return the $garmentSex
     */
    public function getGarmentSex()
    {
        return $this->garmentSex;
    }

    /**
     *
     * @param \Settings\Entity\Sex $garmentSex            
     */
    public function setGarmentSex($garmentSex)
    {
        $this->garmentSex = $garmentSex;
        return $this;
    }
    /**
     * @return the $relatedProducts
     */
    public function getRelatedProducts()
    {
        return $this->relatedProducts;
    }
    
    
    public function addRelatedProducts($relatedProducts){
        
    }

}
