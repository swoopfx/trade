<?php
namespace Support\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="support_message_state")
 * 
 * @author otaba
 *        
 */
class SupportMessageState
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * This is either sender or recipient
     *
     * @ORM\Column(name="state", type="string", nullable=false)
     *
     * @var string
     */
    private $function;

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
     * @return the $function
     */
    public function getFunction()
    {
        return $this->function;
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
     * @param string $function
     */
    public function setFunction($function)
    {
        $this->function = $function;
        return $this;
    }

}

