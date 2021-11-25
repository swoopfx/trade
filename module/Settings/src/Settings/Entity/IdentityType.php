<?php
namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * International Passport
 * Driver Liscence
 * 
 * @ORM\Entity
 * @ORM\Table(name="identity_type")
 * @author otaba
 *
 */
class IdentityType
{
    
    /**
     *
     * @var integer @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     *
     */
    private  $id;
    
    /**
     * @ORM\Column(name="type", type="string", nullable=true)
     * @var string
     */
    private $type;

    public  function getId(){
        return $this->id;
    }
    /**
     * @return string
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
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

}

