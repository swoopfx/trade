<?php
namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Settings\Entity\Repository\GarmentSizeRepository")
 * @ORM\Table(name="fabric_sizes")
 *
 * @author otaba
 *        
 */
class Size
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="collar", type="string", nullable=true)
     * 
     * @var string
     */
    private $collar;

    /**
     * 2-4, 4-8
     * This is the convemntional size range
     * @ORM\Column(name="size_range", type="string", nullable=true)
     *
     * @var string
     */
    private $sizeRange;

    /**
     * The sex involved
     * @ORM\ManyToOne(targetEntity="Sex")
     *
     * @var Sex
     */
    private $sex;

    /**
     * @ORM\ManyToOne(targetEntity="SizeCategory")
     *
     * @var SizeCategory
     */
    private $sizeCategory;

    /**
     * @ORM\Column(name="size", type="string", nullable=true)
     *
     * @var string
     */
    private $size;

    /**
     * @ORM\Column(name="bust", type="string", nullable=true)
     *
     * @var string
     */
    private $bust;

    /**
     * @ORM\Column(name="natural_waist", type="string", nullable=true)
     *
     * @var string
     */
    private $naturalWaist;

    /**
     * @ORM\Column(name="hip", type="string", nullable=true)
     *
     * @var string
     */
    private $hip;

    /**
     * @ORM\Column(name="overarm", type="string", nullable=true)
     *
     * @var string
     */
    private $overarm;

    /**
     * @ORM\Column(name="low_waist", type="string", nullable=true)
     *
     * @var string
     */
    private $lowWaist;

    /**
     * @ORM\Column(name="innerleg", type="string", nullable=true)
     *
     * @var string
     */
    private $innerLeg;

    /**
     * @ORM\Column(name="sleeve", type="string", nullable=true)
     *
     * @var string
     */
    private $sleeve;
    
    /**
     * @ORM\ManyToOne(targetEntity="MaturityCategroy")
     * @var MaturityCategroy
     */
    private $maturityCategory;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

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
     * @return the $sizeCategory
     */
    public function getSizeCategory()
    {
        return $this->sizeCategory;
    }

    /**
     *
     * @return the $size
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     *
     * @return the $bust
     */
    public function getBust()
    {
        return $this->bust;
    }

    /**
     *
     * @return the $naturalWaist
     */
    public function getNaturalWaist()
    {
        return $this->naturalWaist;
    }

    /**
     *
     * @return the $hip
     */
    public function getHip()
    {
        return $this->hip;
    }

    /**
     *
     * @return the $overarm
     */
    public function getOverarm()
    {
        return $this->overarm;
    }

    /**
     *
     * @return the $lowWaist
     */
    public function getLowWaist()
    {
        return $this->lowWaist;
    }

    /**
     *
     * @return the $innerLeg
     */
    public function getInnerLeg()
    {
        return $this->innerLeg;
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
     * @param \Settings\Entity\SizeCategory $sizeCategory            
     */
    public function setSizeCategory($sizeCategory)
    {
        $this->sizeCategory = $sizeCategory;
        return $this;
    }

    /**
     *
     * @param string $size            
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     *
     * @param string $bust            
     */
    public function setBust($bust)
    {
        $this->bust = $bust;
        return $this;
    }

    /**
     *
     * @param string $naturalWaist            
     */
    public function setNaturalWaist($naturalWaist)
    {
        $this->naturalWaist = $naturalWaist;
        return $this;
    }

    /**
     *
     * @param string $hip            
     */
    public function setHip($hip)
    {
        $this->hip = $hip;
        return $this;
    }

    /**
     *
     * @param string $overarm            
     */
    public function setOverarm($overarm)
    {
        $this->overarm = $overarm;
        return $this;
    }

    /**
     *
     * @param string $lowWaist            
     */
    public function setLowWaist($lowWaist)
    {
        $this->lowWaist = $lowWaist;
        return $this;
    }

    /**
     *
     * @param string $innerLeg            
     */
    public function setInnerLeg($innerLeg)
    {
        $this->innerLeg = $innerLeg;
        return $this;
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
     * @param \Settings\Entity\Sex $sex            
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
        return $this;
    }

    /**
     *
     * @return the $sleeve
     */
    public function getSleeve()
    {
        return $this->sleeve;
    }

    /**
     *
     * @param string $sleeve            
     */
    public function setSleeve($sleeve)
    {
        $this->sleeve = $sleeve;
        return $this;
    }

    /**
     *
     * @return the $sizeRange
     */
    public function getSizeRange()
    {
        return $this->sizeRange;
    }

    /**
     *
     * @param string $sizeRange            
     */
    public function setSizeRange($sizeRange)
    {
        $this->sizeRange = $sizeRange;
        return $this;
    }
    /**
     * @return the $collar
     */
    public function getCollar()
    {
        return $this->collar;
    }

    /**
     * @param string $collar
     */
    public function setCollar($collar)
    {
        $this->collar = $collar;
        return $this;
    }
    /**
     * @return the $maturityCategory
     */
    public function getMaturityCategory()
    {
        return $this->maturityCategory;
    }

    /**
     * @param \Settings\Entity\MaturityCategroy $maturityCategory
     */
    public function setMaturityCategory($maturityCategory)
    {
        $this->maturityCategory = $maturityCategory;
        return $this;
    }


}

