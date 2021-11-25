<?php
namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductAttribute
 *
 * @ORM\Table(name="product_attribute")
 * @ORM\Entity
 */
class ProductAttribute
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="productAttributes")
     * 
     * @var Product
     */
    private $product;

    /**
     * @ORM\Column(name="attributes_name", type="string", nullable=true)
     * 
     * @var string
     */
    private $attributeName;

    /**
     *
     * @var string @ORM\Column(name="attribute_text", type="text", length=65535, nullable=false)
     */
    private $attributetext;

    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     * 
     * @var \DateTime
     */
    private $createdOn;

    /**
     * @ORM\Column(name="updated_on", type="datetime", nullable=true)
     * 
     * @var \DateTime;
     */
    private $updatedOn;
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
     * @return the $attributeName
     */
    public function getAttributeName()
    {
        return $this->attributeName;
    }

    /**
     * @return the $attributetext
     */
    public function getAttributetext()
    {
        return $this->attributetext;
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
     * @param string $attributeName
     */
    public function setAttributeName($attributeName)
    {
        $this->attributeName = $attributeName;
        return $this;
    }

    /**
     * @param string $attributetext
     */
    public function setAttributetext($attributetext)
    {
        $this->attributetext = $attributetext;
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
     * @param DateTime; $updatedOn
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;
        return $this;
    }

}
