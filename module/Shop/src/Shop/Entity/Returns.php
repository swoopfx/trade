<?php

namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Return
 *
 * @ORM\Table(name="returns")
 * @ORM\Entity
 */
class Returns
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
     * @var int
     *
     * @ORM\Column(name="order_id", type="integer", nullable=false)
     */
    private $orderId;

    /**
     * @var int
     *
     * @ORM\Column(name="product_id", type="integer", nullable=false)
     */
    private $productId;

    /**
     * @var int
     *
     * @ORM\Column(name="customer_id", type="integer", nullable=false)
     */
    private $customerId;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=32, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=32, nullable=false)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=96, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=32, nullable=false)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="product", type="string", length=255, nullable=false)
     */
    private $product;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=64, nullable=false)
     */
    private $model;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var bool
     *
     * @ORM\Column(name="opened", type="boolean", nullable=false)
     */
    private $opened;

    /**
     * @var int
     *
     * @ORM\Column(name="return_reason_id", type="integer", nullable=false)
     */
    private $returnReasonId;

    /**
     * @var int
     *
     * @ORM\Column(name="return_action_id", type="integer", nullable=false)
     */
    private $returnActionId;

    /**
     * @var ReturnStatus
     *
     * @ORM\ManyToOne(targetEntity="ReturnStatus")
     */
    private $returnStatus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=true)
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     */
   private $createdOn;
   
   /**
    * @var \DateTime
    *
    * @ORM\Column(name="updated_on", type="datetime", nullable=false)
    */
   private $updatedOn;
   


}
