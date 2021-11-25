<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderTotal
 *
 * @ORM\Table(name="order_total", indexes={@ORM\Index(name="order_id", columns={"order_id"})})
 * @ORM\Entity
 */
class OrderTotal
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
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=32, nullable=false)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="decimal", precision=15, scale=4, nullable=false, options={"default"="0.0000"})
     */
    private $value = '0.0000';

    /**
     * @var int
     *
     * @ORM\Column(name="sort_order", type="integer", nullable=false)
     */
    private $sortOrder;


}
