<?php
namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VAT 7.5
 * @ORM\Entity
 * @ORM\Table(name="retailer_tax")
 * 
 * @author otaba
 *        
 */
class Tax
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="tax_name", type="string", nullable=true)
     * 
     * @var string
     */
    private $taxName;

    /**
     * @ORM\Column(name="tax_value", type="string", nullable=true)
     * 
     * @var string
     */
    private $taxValue;

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
     * @return the $taxName
     */
    public function getTaxName()
    {
        return $this->taxName;
    }

    /**
     * @return the $taxValue
     */
    public function getTaxValue()
    {
        return $this->taxValue;
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
     * @param string $taxName
     */
    public function setTaxName($taxName)
    {
        $this->taxName = $taxName;
        return $this;
    }

    /**
     * @param string $taxValue
     */
    public function setTaxValue($taxValue)
    {
        $this->taxValue = $taxValue;
        return $this;
    }

}

