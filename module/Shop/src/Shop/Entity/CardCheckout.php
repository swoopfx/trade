<?php
namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="card_checkout")
 * @author mac
 *        
 */
class CardCheckout
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\Column(name="checkout_uid", type="string", nullable=true)
     * @var string
     */
    private $checkoutUid;
    
    /**
     * @ORM\ManyToOne(targetEntity="CartOrders")
     * @var CartOrders
     */
    private $cartOrders;
    
    /**
     * @ORM\Column(name="is_open", type="boolean", nullable=false, options={"default":"1"})
     * @var boolean
     */
    private $isOpen;
    
    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     * @var \DateTime
     */
    private $createdOn;
    
    /**
     * @ORM\Column(name="updated_on", type="datetime", nullable=false)
     * @var \DateTime
     */
    private $updatedOn;
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
}

