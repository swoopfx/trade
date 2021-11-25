<?php
namespace Settings\Entity;

use Doctrine\ORM\Mapping  as ORM;
/**
 * KG Converter
 * Ounce Converter
 * 
 * @ORM\Entity
 * @ORM\Table(name="weight_class")
 * @author otaba
 *        
 */
class WeightClass
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\Column(name="class_name", type="string", nullable=true)
     *
     * @var string
     */
    private $classname;
    
    /**
     * @ORM\Column(name="weight_value", type="string", nullable=true)
     *
     * @var string
     */
    private $weight_value;
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
}

