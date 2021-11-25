<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recurring
 *
 * @ORM\Table(name="recurring")
 * @ORM\Entity
 */
class Recurring
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
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=4, nullable=false)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="duration", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $duration;

    /**
     * @var int
     *
     * @ORM\Column(name="cycle", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $cycle;

    /**
     * @var bool
     *
     * @ORM\Column(name="trial_status", type="boolean", nullable=false)
     */
    private $trialStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="trial_price", type="decimal", precision=10, scale=4, nullable=false)
     */
    private $trialPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="trial_duration", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $trialDuration;

    /**
     * @var int
     *
     * @ORM\Column(name="trial_cycle", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $trialCycle;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status;

    /**
     * @var int
     *
     * @ORM\Column(name="sort_order", type="integer", nullable=false)
     */
    private $sortOrder;


}
