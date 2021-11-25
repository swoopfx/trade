<?php
namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="product_category")
 * @ORM\Entity(repositoryClass="Shop\Entity\Repository\CategoryRepository")
 */

// , indexes={@ORM\Index(name="parent_id", columns={"parent_id"})}
class Category
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="category_uid", type="string", nullable=true)
     * 
     * @var string
     */
    private $categoryUid;

    /**
     * Name of the category
     * @ORM\Column(name="category", type="string", nullable=false)
     *
     * @var string
     */
    private $category;

    /**
     *
     * @var Image @ORM\ManyToOne(targetEntity="Image")
     */
    private $image;

    /**
     * @ORM\Column(name="slug", type="string", nullable=true)
     * 
     * @var string
     *
     */
    private $slug;

    /**
     *
     * @var \DateTime @ORM\Column(name="date_added", type="datetime", nullable=true)
     */
    private $dateAdded;

    /**
     *
     * @var \DateTime @ORM\Column(name="date_modified", type="datetime", nullable=true)
     */
    private $dateModified;

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
     * @return the $category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     *
     * @return the $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     *
     * @return the $top
     */
    public function getTop()
    {
        return $this->top;
    }

    /**
     *
     * @return the $column
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     *
     * @return the $sortOrder
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     *
     * @return the $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     *
     * @return the $dateAdded
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     *
     * @return the $dateModified
     */
    public function getDateModified()
    {
        return $this->dateModified;
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
     * @param string $category            
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     *
     * @param \Shop\Entity\Image $image            
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     *
     * @param boolean $top            
     */
    public function setTop($top)
    {
        $this->top = $top;
        return $this;
    }

    /**
     *
     * @param number $column            
     */
    public function setColumn($column)
    {
        $this->column = $column;
        return $this;
    }

    /**
     *
     * @param number $sortOrder            
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    /**
     *
     * @param boolean $status            
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     *
     * @param DateTime $dateAdded            
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;
        $this->dateModified = $dateAdded;
        return $this;
    }

    /**
     *
     * @param DateTime $dateModified            
     */
    public function setDateModified($dateModified)
    {
        $this->dateModified = $dateModified;
        return $this;
    }

    /**
     *
     * @return the $categoryUid
     */
    public function getCategoryUid()
    {
        return $this->categoryUid;
    }

    /**
     *
     * @param string $categoryUid            
     */
    public function setCategoryUid($categoryUid)
    {
        $this->categoryUid = $categoryUid;
        return $this;
    }
    /**
     * @return the $slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

}
