<?php

namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductRelated
 *
 * @ORM\Table(name="product_related")
 * @ORM\Entity
 */
class ProductRelated
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Product
     *
     *
     * @ORM\ManyToOne(targetEntity="Product")
     */
    private $relatedId;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="Product")
     * @var Product
     */
    private $productId;
    
    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     * @var Datetime
     */
    private $createdOn;
    /**
     * @return the $createdOn
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param \Shop\Entity\Datetime $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }

    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $relatedId
     */
    public function getRelatedId()
    {
        return $this->relatedId;
    }

    /**
     * @return the $productId
     */
    public function getProductId()
    {
        return $this->productId;
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
     * @param \Shop\Entity\Product $relatedId
     */
    public function setRelatedId($relatedId)
    {
        $this->relatedId = $relatedId;
        return $this;
    }

    /**
     * @param \Shop\Entity\Product $productId
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }



}
