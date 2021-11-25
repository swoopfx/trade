<?php
namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_tracking")
 * 
 * @author otaba
 *        
 */
class OrderTracking
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="CartOrders", inversedBy="tracking")
     * 
     * @var CartOrders
     */
    private $order;

    /**
     * @ORM\ManyToOne(targetEntity="TrackingStatus")
     * 
     * @var TrackingStatus
     */
    private $trackingStatus;

    /**
     * @ORM\Column(name="tracking_comment", type="text", nullable=true)
     * 
     * @var string
     */
    private $trackingComment;

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
        
        
    }
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return the $trackingStatus
     */
    public function getTrackingStatus()
    {
        return $this->trackingStatus;
    }

    /**
     * @return the $trackingComment
     */
    public function getTrackingComment()
    {
        return $this->trackingComment;
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
     * @param \Shop\Entity\Order $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @param \Shop\Entity\TrackingStatus $trackingStatus
     */
    public function setTrackingStatus($trackingStatus)
    {
        $this->trackingStatus = $trackingStatus;
        return $this;
    }

    /**
     * @param string $trackingComment
     */
    public function setTrackingComment($trackingComment)
    {
        $this->trackingComment = $trackingComment;
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

