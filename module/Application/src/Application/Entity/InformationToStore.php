<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InformationToStore
 *
 * @ORM\Table(name="information_to_store")
 * @ORM\Entity
 */
class InformationToStore
{
    /**
     * @var int
     *
     * @ORM\Column(name="information_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $informationId;

    /**
     * @var int
     *
     * @ORM\Column(name="store_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $storeId;


}
