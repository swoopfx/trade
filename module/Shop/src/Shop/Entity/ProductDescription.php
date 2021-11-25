<?php
namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductDescription
 *
 * @ORM\Table(name="product_description", indexes={@ORM\Index(name="product_name", columns={"product_name"})})
 * @ORM\Entity
 */
class ProductDescription
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    // /**
    // * @var int
    // *
    // * @ORM\Column(name="language_id", type="integer", nullable=false)
    // * @ORM\Id
    // * @ORM\GeneratedValue(strategy="NONE")
    // */
    // private $languageId;
    
//     private $
    
    /**
     *
     * @var string @ORM\Column(name="product_name", type="string", length=255, nullable=false)
     */
    private $productName;

    /**
     * references the product entity
     * 
     * @var Product @ORM\OneToOne(targetEntity="Product", inversedBy="productDescription")
     */
    private $product;

    /**
     * detailed descriptiopon of the product
     * 
     * @var string @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * Used as Tags by the html header
     * 
     * @var string @ORM\Column(name="tag", type="text", length=65535, nullable=true)
     */
    private $tag;

    /**
     * Used By The html value to describe the head title
     * 
     * @var string @ORM\Column(name="meta_title", type="string", length=255, nullable=true)
     */
    private $metaTitle;

    /**
     * This is used by the html head tag to descibe the product
     * 
     * @var string @ORM\Column(name="meta_description", type="string", length=255, nullable=true)
     */
    private $metaDescription;

    /**
     * Keywords to be used by the html head
     * 
     * @var string @ORM\Column(name="meta_keyword", type="string", length=255, nullable=true)
     */
    private $metaKeyword;

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
     * @return the $product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     *
     * @return the $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     *
     * @return the $tag
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     *
     * @return the $metaTitle
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     *
     * @return the $metaDescription
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     *
     * @return the $metaKeyword
     */
    public function getMetaKeyword()
    {
        return $this->metaKeyword;
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
     * @param \Shop\Entity\Product $product            
     */
    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     *
     * @param string $description            
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     *
     * @param string $tag            
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
        return $this;
    }

    /**
     *
     * @param string $metaTitle            
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;
        return $this;
    }

    /**
     *
     * @param string $metaDescription            
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;
        return $this;
    }

    /**
     *
     * @param string $metaKeyword            
     */
    public function setMetaKeyword($metaKeyword)
    {
        $this->metaKeyword = $metaKeyword;
        return $this;
    }
    /**
     * @return the $productName
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * @param string $productName
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;
        return $this;
    }

}
