<?php
namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Male
 * Female
 *
 * @ORM\Entity
 * @ORM\Table("sex")
 * 
 * @author otaba
 *        
 */
class Sex
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="sex", type="string", nullable=false)
     * 
     * @var string
     */
    private $sex;

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
     * @return the $sex
     */
    public function getSex()
    {
        return $this->sex;
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
     * @param string $sex            
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
        return $this;
    }
}

