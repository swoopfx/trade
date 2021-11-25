<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use CsnUser\Entity\User;
use Shop\Entity\Image;

/**
 * @ORM\Entity
 * @ORM\Table(name="new_product")
 *
 * @author mac
 *        
 */
class Newproduct
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     *     
     */
    protected $id;
    
    /**
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $productUid;

    /**
     * @ORM\Column(name="pname", nullable=true)
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(nullable=true)
     * 
     * @var string
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity="Shop\Entity\Image")
     *
     * @var Image
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="CsnUser\Entity\User")
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(name="lat", nullable=true)
     *
     * @var string
     */
    private $lat;

    /**
     * @ORM\Column(name="lon", nullable=true)
     *
     * @var string
     */
    private $lon;

    /**
     * @ORM\Column(name="placeid", nullable=true)
     *
     * @var string
     */
    private $placeId;

    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $createdOn;

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
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return the $address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return the $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return the $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return the $lat
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @return the $lon
     */
    public function getLon()
    {
        return $this->lon;
    }

    /**
     * @return the $placeId
     */
    public function getPlaceId()
    {
        return $this->placeId;
    }

    /**
     * @return the $createdOn
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
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
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @param \Shop\Entity\Image $image
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @param \CsnUser\Entity\User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param string $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
        return $this;
    }

    /**
     * @param string $lon
     */
    public function setLon($lon)
    {
        $this->lon = $lon;
        return $this;
    }

    /**
     * @param string $placeId
     */
    public function setPlaceId($placeId)
    {
        $this->placeId = $placeId;
        return $this;
    }

    /**
     * @param DateTime $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }
    /**
     * @return the $productUid
     */
    public function getProductUid()
    {
        return $this->productUid;
    }

    /**
     * @param string $productUid
     */
    public function setProductUid($productUid)
    {
        $this->productUid = $productUid;
        return $this;
    }

    


}

