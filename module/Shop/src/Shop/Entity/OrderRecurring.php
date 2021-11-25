<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderRecurring
 *
 * @ORM\Table(name="order_recurring")
 * @ORM\Entity
 */
class OrderRecurring
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
     * @ORM\Column(name="reference", type="string", length=255, nullable=false)
     */
    private $reference;

    /**
     * @var int
     *
     * @ORM\Column(name="product_id", type="integer", nullable=false)
     */
    private $productId;

    /**
     * @var string
     *
     * @ORM\Column(name="product_name", type="string", length=255, nullable=false)
     */
    private $productName;

    /**
     * @var int
     *
     * @ORM\Column(name="product_quantity", type="integer", nullable=false)
     */
    private $productQuantity;

    /**
     * @var int
     *
     * @ORM\Column(name="recurring_id", type="integer", nullable=false)
     */
    private $recurringId;

    /**
     * @var string
     *
     * @ORM\Column(name="recurring_name", type="string", length=255, nullable=false)
     */
    private $recurringName;

    /**
     * @var string
     *
     * @ORM\Column(name="recurring_description", type="string", length=255, nullable=false)
     */
    private $recurringDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="recurring_frequency", type="string", length=25, nullable=false)
     */
    private $recurringFrequency;

    /**
     * @var int
     *
     * @ORM\Column(name="recurring_cycle", type="smallint", nullable=false)
     */
    private $recurringCycle;

    /**
     * @var int
     *
     * @ORM\Column(name="recurring_duration", type="smallint", nullable=false)
     */
    private $recurringDuration;

    /**
     * @var string
     *
     * @ORM\Column(name="recurring_price", type="decimal", precision=10, scale=4, nullable=false)
     */
    private $recurringPrice;

    /**
     * @var bool
     *
     * @ORM\Column(name="trial", type="boolean", nullable=false)
     */
    private $trial;

    /**
     * @var string
     *
     * @ORM\Column(name="trial_frequency", type="string", length=25, nullable=false)
     */
    private $trialFrequency;

    /**
     * @var int
     *
     * @ORM\Column(name="trial_cycle", type="smallint", nullable=false)
     */
    private $trialCycle;

    /**
     * @var int
     *
     * @ORM\Column(name="trial_duration", type="smallint", nullable=false)
     */
    private $trialDuration;

    /**
     * @var string
     *
     * @ORM\Column(name="trial_price", type="decimal", precision=10, scale=4, nullable=false)
     */
    private $trialPrice;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_added", type="datetime", nullable=false)
     */
    private $dateAdded;


}
