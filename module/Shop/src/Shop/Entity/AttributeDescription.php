<?php

namespace Shop\Entity;

// use Doctrine\ORM\Mapping as ORM;

// /**
//  * AttributeDescription
//  *
//  * @ORM\Table(name="attribute_description")
//  * @ORM\Entity
//  */
class AttributeDescription
{
    /**
     * @var int
     *
     * @ORM\Column(name="attribute_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $attributeId;

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
     * @ORM\Column(name="name", type="string", length=64, nullable=false)
     */
    private $name;


}
