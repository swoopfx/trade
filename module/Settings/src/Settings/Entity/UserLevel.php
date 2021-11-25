<?php
namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Beginner
 * This defines the levelrange the user has attained
 * @ORM\Entity
 * @ORM\Table(name="user_level")
 * 
 * @author otaba
 *        
 */
class UserLevel
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     *     
     */
    private $id;

    /**
     * @ORM\Column(name="level", type="string", nullable=false)
     * 
     * @var string
     */
    private $level;

    /**
     * @ORM\Column(name="icon", type="string", nullable=false)
     * 
     * @var string
     */
    private $icon;

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
     * @return the $level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return the $icon
     */
    public function getIcon()
    {
        return $this->icon;
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
     * @param string $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @param string $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

}

