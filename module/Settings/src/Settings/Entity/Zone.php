<?php
namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;
use Settings\Entity\Country;

/**
 * Zone
 *
 * @ORM\Table(name="zone")
 * @ORM\Entity
 */
class Zone
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var Country @ORM\ManyToOne(targetEntity="Settings\Entity\Country")
     */
    private $country;

    /**
     *
     * @var string @ORM\Column(name="name", type="string", length=128, nullable=false)
     */
    private $name;

    /**
     *
     * @var string @ORM\Column(name="code", type="string", length=32, nullable=false)
     */
    private $code;

    /**
     *
     * @var bool @ORM\Column(name="status", type="boolean", nullable=false, options={"default"="1"})
     */
    private $status = true;
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return the $code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return the $status
     */
    public function getStatus()
    {
        return $this->status;
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
     * @param \Settings\Entity\Country $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
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
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @param boolean $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

}
