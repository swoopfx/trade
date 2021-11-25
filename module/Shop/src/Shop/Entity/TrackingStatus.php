<?php
namespace Shop\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Shipped
 * Packaging
 * 
 * @ORM\Entity
 * @ORM\Table(name="traking_status")
 * @author otaba
 *        
 */
class TrackingStatus
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\Column(name="status", type="string", nullable=false)
     * @var string
     */
    private $status;
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
}

