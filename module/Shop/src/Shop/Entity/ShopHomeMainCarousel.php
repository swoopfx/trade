<?php
namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This calss procides an entity class for the carousel of the shop home page
 * @ORM\Entity
 * @ORM\Table(name="shop_home_main_carousel")
 *
 * @author otaba
 *        
 */
class ShopHomeMainCarousel
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * This is the small horizontal header text
     * @ORM\Column(name="subheading", type="string", nullable=true)
     * 
     * @var string
     */
    private $subheading;

    /**
     * This is the vartical ext ajacent to the horizontal subheading
     * @ORM\Column(name="vr_h3_text", type="string", nullable=true)
     * 
     * @var string
     */
    private $vrH3Text;

    /**
     * @ORM\OneToOne(targetEntity="Image")
     * 
     * @var Image
     */
    private $bgImage;

    /**
     * @ORM\Column(name="h1_text", type="string", nullable=true)
     * 
     * @var string
     */
    private $h1Text;

    /**
     * @ORM\Column(name="h1_span_text", type="string", nullable=true)
     * 
     * @var string
     */
    private $h1SpanText;

    /**
     * @ORM\Column(name="paragraph_text", type="string", nullable=true)
     * 
     * @var string
     */
    private $paragraphText;

    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     * 
     * @var \DateTime
     */
    private $createdOn;

    /**
     * @ORM\Column(name="updated_on", type="datetime", nullable=true)
     * 
     * @var \DateTime
     */
    private $updatedOn;

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
     * @return the $subheading
     */
    public function getSubheading()
    {
        return $this->subheading;
    }

    /**
     * @return the $vrH3Text
     */
    public function getVrH3Text()
    {
        return $this->vrH3Text;
    }

    /**
     * @return the $bgImage
     */
    public function getBgImage()
    {
        return $this->bgImage;
    }

    /**
     * @return the $h1Text
     */
    public function getH1Text()
    {
        return $this->h1Text;
    }

    /**
     * @return the $h1SpanText
     */
    public function getH1SpanText()
    {
        return $this->h1SpanText;
    }

    /**
     * @return the $paragraphText
     */
    public function getParagraphText()
    {
        return $this->paragraphText;
    }

    /**
     * @return the $createdOn
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @return the $updatedOn
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
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
     * @param string $subheading
     */
    public function setSubheading($subheading)
    {
        $this->subheading = $subheading;
        return $this;
    }

    /**
     * @param string $vrH3Text
     */
    public function setVrH3Text($vrH3Text)
    {
        $this->vrH3Text = $vrH3Text;
        return $this;
    }

    /**
     * @param \Shop\Entity\Image $bgImage
     */
    public function setBgImage($bgImage)
    {
        $this->bgImage = $bgImage;
        return $this;
    }

    /**
     * @param string $h1Text
     */
    public function setH1Text($h1Text)
    {
        $this->h1Text = $h1Text;
        return $this;
    }

    /**
     * @param string $h1SpanText
     */
    public function setH1SpanText($h1SpanText)
    {
        $this->h1SpanText = $h1SpanText;
        return $this;
    }

    /**
     * @param string $paragraphText
     */
    public function setParagraphText($paragraphText)
    {
        $this->paragraphText = $paragraphText;
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
     * @param DateTime $updatedOn
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;
        return $this;
    }

}

