<?php
namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UK
 * US
 * EU
 * CHINA
 *
 * @ORM\Entity
 * @ORM\Table(name="fabric_size_category")
 * 
 * @author otaba
 *        
 */
class SizeCategory
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="category", type="string", nullable=false)
     * 
     * @var string
     */
    private $category;

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
     * @return the $category
     */
    public function getCategory()
    {
        return $this->category;
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
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

}

