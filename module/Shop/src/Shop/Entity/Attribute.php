<?php

namespace Shop\Entity;

// use Doctrine\ORM\Mapping as ORM;

// /**
//  * Attribute
//  *
//  * @ORM\Table(name="attribute")
//  * @ORM\Entity
//  */
class Attribute
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
     * 
     * @var string
     */
    private $name;


}
