<?php
namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductDiscount
 *
 * @ORM\Table(name="product_discount", indexes={@ORM\Index(name="id", columns={"product_id"})})
 * @ORM\Entity
 */
class ProductDiscount
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var int @ORM\OneToOne(targetEntity="Product", inversedBy="discount")
     *      @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * @var Product
     */
    private $product;

    /**
     *
     * @var int Minimum qauntity requred for discount to take place
     *      @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity = '1';

    /**
     *
     * @var int @ORM\Column(name="priority", type="integer", nullable=false, options={"default"="1"})
     */
    private $priority = '1';

    /**
     * Campaign price
     *
     * @var string @ORM\Column(name="price", type="string", nullable=false, options={"default"="0.0000"})
     */
    private $discountPrice = '0.0000';

    /**
     * Date the campaign would start
     *
     * @var \DateTime @ORM\Column(name="date_start", type="datetime", nullable=false)
     */
    private $dateStart = '0000-00-00';

    /**
     * Date campaign would end
     *
     * @var \DateTime @ORM\Column(name="date_end", type="datetime", nullable=false)
     */
    private $dateEnd = '0000-00-00';

    /**
     * Date Discount was created
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
     * @return the $quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     *
     * @return the $priority
     */
    public function getPriority()
    {
        return $this->priority;
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
     * @return the $dateStart
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     *
     * @return the $dateEnd
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
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
     * @param number $product            
     */
    public function setProduct($product)
    {
        $this->product = $product;
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
     * @param number $priority            
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
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
     * @param DateTime $dateStart            
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;
        return $this;
    }

    /**
     *
     * @param DateTime $dateEnd            
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;
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
     * @return the $discountPrice
     */
    public function getDiscountPrice()
    {
        return $this->discountPrice;
    }

    /**
     * @param string $discountPrice
     */
    public function setDiscountPrice($discountPrice)
    {
        $this->discountPrice = $discountPrice;
        return $this;
    }

}
