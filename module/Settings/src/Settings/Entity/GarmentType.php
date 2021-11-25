<?php
namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;
use Shop\Entity\Category;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Shirt
 * Gown
 * Skirt
 * Sweats
 * Trousers
 * @ORM\Entity(repositoryClass="Settings\Entity\Repository\GarmentTypeRepository")
 * @ORM\Table(name="garment_type")
 * 
 * @author otaba
 *        
 */
class GarmentType
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Shop\Entity\Category")
     * @var Category
     */
    private $category;

    /**
     * @ORM\Column(name="garment_type", type="string", nullable=false)
     * 
     * @var string
     */
    private $garmentType;

    /**
     */
    public function __construct()
    {
        
        $this->category = new ArrayCollection();
    }

    /**
     *
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return the $garmentType
     */
    public function getGarmentType()
    {
        return $this->garmentType;
    }

    /**
     *
     * @param number $id            
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @param string $garmentType            
     */
    public function setGarmentType($garmentType)
    {
        $this->garmentType = $garmentType;
        return $this;
    }
}

