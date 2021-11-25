<?php

namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WeightClassDescription
 *
 * @ORM\Table(name="weight_class_description")
 * @ORM\Entity
 */
class WeightClassDescription
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $weightClassId;

    /**
     * @var int
     *
     * @ORM\Column(name="language_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $languageId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=32, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="unit", type="string", length=4, nullable=false)
     */
    private $unit;


}
