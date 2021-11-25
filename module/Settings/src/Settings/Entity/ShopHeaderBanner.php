<?php
namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="shop_header_banner")
 * @author otaba
 *        
 */
class ShopHeaderBanner
{
    
    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\Column(name="namex", type="string", nullable=false)
     * @var string
     */
    private $namex;
    
    /**
     * @ORM\Column(name="banner", type="string", nullable=false)
     * @var string
     */
    private $banner;
    
    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     * @var unknown
     */
    private $createdOn;
    
    /**
     * @ORM\Column(name="updated_on", type="datetime", nullable=false)
     * @var unknown
     */
    private $updatedOn;

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
}

