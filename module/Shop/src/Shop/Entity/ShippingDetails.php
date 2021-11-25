<?php
namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;
use CsnUser\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="shipping_details")
 * @author otaba
 *        
 */
class ShippingDetails
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\OneToOne(targetEntity="CsnUser\Entity\User")
     * @var User
     */
    private $user;
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
}

