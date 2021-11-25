<?php
namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * provides the amount of time thie actual product was viewed
 * @ORM\Entity
 * @ORM\Table(name="product_viewd_count")
 * 
 * @author otaba
 *        
 */
class ProductViewCount
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
     * 
     * @var Product
     */
    private $product;

    /**
     * @ORM\Column(name="view_count", type="integer", nullable=false)
     * 
     * @var int
     */
    private $count;

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
     * @return the $count
     */
    public function getCount()
    {
        return $this->count;
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
     * @param number $count
     */
    public function setCount($count)
    {
        $this->count = $count;
        return $this;
    }

}

