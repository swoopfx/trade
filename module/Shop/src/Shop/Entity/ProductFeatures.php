<?php
namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;
use Settings\Entity\ProductFeatureType;

/**
 * This determines the color, Fabric type,
 * @ORM\Entity
 * @ORM\Table(name="product_features")
 * 
 * @author otaba
 *        
 */
class ProductFeatures
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="productFeatures")
     * 
     * @var Product
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="Settings\Entity\ProductFeatureType")
     * 
     * @var ProductFeatureType
     */
    private $featureType;

    /**
     * @ORM\Column(name="feature_info", type="text", nullable=true)
     * 
     * @var string
     */
    private $featurInfo;

    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     * 
     * @var \DateTime
     */
    private $createdOn;

    /**
     * @ORM\Column(name="updated_on", type="datetime", nullable=true)
     * 
     * @var \DateTime
     */
    private $updatedOn;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return the $featureType
     */
    public function getFeatureType()
    {
        return $this->featureType;
    }

    /**
     * @return the $featurInfo
     */
    public function getFeaturInfo()
    {
        return $this->featurInfo;
    }

    /**
     * @return the $createdOn
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @return the $updatedOn
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param \Shop\Entity\Product $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @param \Settings\Entity\ProductFeatureType $featureType
     */
    public function setFeatureType($featureType)
    {
        $this->featureType = $featureType;
        return $this;
    }

    /**
     * @param \Shop\Entity\unknown $featurInfo
     */
    public function setFeaturInfo($featurInfo)
    {
        $this->featurInfo = $featurInfo;
        return $this;
    }

    /**
     * @param DateTime $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }

    /**
     * @param DateTime $updatedOn
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;
        return $this;
    }

}

