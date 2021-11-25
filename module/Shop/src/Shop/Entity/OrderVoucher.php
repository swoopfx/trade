<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderVoucher
 *
 * @ORM\Table(name="order_voucher")
 * @ORM\Entity
 */
class OrderVoucher
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
     * @ORM\Column(name="voucher_id", type="integer", nullable=false)
     */
    private $voucherId;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=10, nullable=false)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="from_name", type="string", length=64, nullable=false)
     */
    private $fromName;

    /**
     * @var string
     *
     * @ORM\Column(name="from_email", type="string", length=96, nullable=false)
     */
    private $fromEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="to_name", type="string", length=64, nullable=false)
     */
    private $toName;

    /**
     * @var string
     *
     * @ORM\Column(name="to_email", type="string", length=96, nullable=false)
     */
    private $toEmail;

    /**
     * @var int
     *
     * @ORM\Column(name="voucher_theme_id", type="integer", nullable=false)
     */
    private $voucherThemeId;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", length=65535, nullable=false)
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=15, scale=4, nullable=false)
     */
    private $amount;


}
