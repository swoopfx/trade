<?php
namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="shop_home_splash_row")
 * 
 * @author otaba
 *        
 */
class ShopHomeSplashRow
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Image")
     * 
     * @var Image
     */
    private $imageTop;

    /**
     * @ORM\Column(name="h2_header_top", type="string", nullable=true)
     * 
     * @var string
     */
    private $h2HeaderTop;

    /**
     * @ORM\Column(name="paragrapgh_top", type="string", nullable=true)
     * 
     * @var string
     */
    private $paragraphTop;

    /**
     * @ORM\Column(name="is_button_top", type="boolean", nullable=true)
     * 
     * @var boolean
     */
    private $isButtonTop;

    /**
     * @ORM\Column(name="button_url_top", type="string", nullable=true)
     * 
     * @var string
     */
    private $buttonUrlTop;

    /**
     * @ORM\ManyToOne(targetEntity="Image")
     * 
     * @var Image
     */
    private $imageBottom;

    /**
     * @ORM\Column(name="h2_header_buttom", type="string", nullable=true)
     * 
     * @var string
     */
    private $h2HeaderBottom;

    /**
     * @ORM\Column(name="pragraph_bottom", type="string", nullable=true)
     * 
     * @var string
     */
    private $paragraphBottom;

    /**
     * @ORM\Column(name="is_button_bottom", type="boolean", nullable=true)
     * 
     * @var string
     */
    private $isButtonBottom;

    /**
     * @ORM\Column(name="button_url_bottom", type="string", nullable=true)
     * 
     * @var string
     */
    private $buttonUrlBottom;

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
     * @return the $imageTop
     */
    public function getImageTop()
    {
        return $this->imageTop;
    }

    /**
     * @return the $h2HeaderTop
     */
    public function getH2HeaderTop()
    {
        return $this->h2HeaderTop;
    }

    /**
     * @return the $paragraphTop
     */
    public function getParagraphTop()
    {
        return $this->paragraphTop;
    }

    /**
     * @return the $isButtonTop
     */
    public function getIsButtonTop()
    {
        return $this->isButtonTop;
    }

    /**
     * @return the $buttonUrlTop
     */
    public function getButtonUrlTop()
    {
        return $this->buttonUrlTop;
    }

    /**
     * @return the $imageBottom
     */
    public function getImageBottom()
    {
        return $this->imageBottom;
    }

    /**
     * @return the $h2HeaderBottom
     */
    public function getH2HeaderBottom()
    {
        return $this->h2HeaderBottom;
    }

    /**
     * @return the $paragraphBottom
     */
    public function getParagraphBottom()
    {
        return $this->paragraphBottom;
    }

    /**
     * @return the $isButtonBottom
     */
    public function getIsButtonBottom()
    {
        return $this->isButtonBottom;
    }

    /**
     * @return the $buttonUrlBottom
     */
    public function getButtonUrlBottom()
    {
        return $this->buttonUrlBottom;
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
     * @param \Shop\Entity\Image $imageTop
     */
    public function setImageTop($imageTop)
    {
        $this->imageTop = $imageTop;
        return $this;
    }

    /**
     * @param string $h2HeaderTop
     */
    public function setH2HeaderTop($h2HeaderTop)
    {
        $this->h2HeaderTop = $h2HeaderTop;
        return $this;
    }

    /**
     * @param string $paragraphTop
     */
    public function setParagraphTop($paragraphTop)
    {
        $this->paragraphTop = $paragraphTop;
        return $this;
    }

    /**
     * @param boolean $isButtonTop
     */
    public function setIsButtonTop($isButtonTop)
    {
        $this->isButtonTop = $isButtonTop;
        return $this;
    }

    /**
     * @param string $buttonUrlTop
     */
    public function setButtonUrlTop($buttonUrlTop)
    {
        $this->buttonUrlTop = $buttonUrlTop;
        return $this;
    }

    /**
     * @param \Shop\Entity\Image $imageBottom
     */
    public function setImageBottom($imageBottom)
    {
        $this->imageBottom = $imageBottom;
        return $this;
    }

    /**
     * @param string $h2HeaderBottom
     */
    public function setH2HeaderBottom($h2HeaderBottom)
    {
        $this->h2HeaderBottom = $h2HeaderBottom;
        return $this;
    }

    /**
     * @param string $paragraphBottom
     */
    public function setParagraphBottom($paragraphBottom)
    {
        $this->paragraphBottom = $paragraphBottom;
        return $this;
    }

    /**
     * @param string $isButtonBottom
     */
    public function setIsButtonBottom($isButtonBottom)
    {
        $this->isButtonBottom = $isButtonBottom;
        return $this;
    }

    /**
     * @param string $buttonUrlBottom
     */
    public function setButtonUrlBottom($buttonUrlBottom)
    {
        $this->buttonUrlBottom = $buttonUrlBottom;
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

