<?php
namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;
use Settings\Entity\Size;

/**
 * @ORM\Entity
 * @ORM\Table(name="product_availaible_sizes")
 * 
 * @author otaba
 *        
 */
class ProductAvailableSizes
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Settings\Entity\Size")
     * @ORM\JoinColumn(name="size", referencedColumnName="id")
     * @var Size
     */
    private $sizes;

    /**
     * @ORM\ManyToOne(targetEntity="Shop\Entity\Product", inversedBy="availaibleSizes")
     * @ORM\JoinColumn(name="product", referencedColumnName="id")
     * @var Product
     */
    private $product;

    /**
     * @ORM\Column(name="availaible_quantity", type="string", nullable=false)
     * @var string
     */
    private $avalaibleQuantity;

    /**
     * @var \DateTime @ORM\Column(name="created_on", type="datetime", nullable=false)
     * 
     */
    private $createdOn;

    /**
     *
     * @var \DateTime @ORM\Column(name="updated_on", type="datetime", nullable=false)
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
     * @return the $sizes
     */
    public function getSizes()
    {
        return $this->sizes;
    }

    /**
     * @return the $product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return the $avalaibleQuantity
     */
    public function getAvalaibleQuantity()
    {
        return $this->avalaibleQuantity;
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
     * @param \Settings\Entity\Size $sizes
     */
    public function setSizes($sizes)
    {
        $this->sizes = $sizes;
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
     * @param string $avalaibleQuantity
     */
    public function setAvalaibleQuantity($avalaibleQuantity)
    {
        $this->avalaibleQuantity = $avalaibleQuantity;
        return $this;
    }

    /**
     * @param DateTime $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        $this->updatedOn = $createdOn;
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

