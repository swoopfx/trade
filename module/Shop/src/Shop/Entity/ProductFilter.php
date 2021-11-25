<?php

namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductFilter
 *
 * @ORM\Table(name="product_filter")
 * @ORM\Entity
 */
class ProductFilter
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="filter_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $filterId;


}
