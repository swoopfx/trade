<?php
namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * this provides a count for dsales of each product
 * @ORM\Entity
 * @ORM\Table(name="product_sales_count", indexes={@ORM\Index(name="id", columns={"product_id", "product_count"})})
 *
 * @author otaba
 *        
 */
class ProductSalesCount
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     *
     * @var Product
     */
    private $product;

    /**
     * @ORM\Column(name="product_count", type="string", nullable=false)
     *
     * @var string
     */
    private $productCount = 0;

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
     * @return the $productCount
     */
    public function getProductCount()
    {
        return $this->productCount;
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
     * @param string $productCount
     */
    public function setProductCount($productCount)
    {
        $this->productCount = $productCount;
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

