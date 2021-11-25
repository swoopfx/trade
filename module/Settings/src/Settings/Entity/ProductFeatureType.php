<?php
namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Color
 * Texture
 * Fabric Type
 * @ORM\Entity
 * @ORM\Table(name="product_feature_type")
 * 
 * @author otaba
 *        
 */
class ProductFeatureType
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="feature_type", type="string", nullable=true)
     * @var string
     */
    private $type;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param field_type $type
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

}

