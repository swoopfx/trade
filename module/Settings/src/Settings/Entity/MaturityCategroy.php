<?php
namespace Settings\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * This is ADult 10
 * CHILDREN 100
 * 
 * @author Ajayi Oluwaseun Ezekiel (ezekiel_a@yahoo.com)
 * @copyright 7 Apr 2021 I-Manager Solutions, Nigeria
 *            project_name
 *            @ORM\Entity
 *            @ORM\Table(name="maturity_category")
 *           
 */
class MaturityCategroy
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="category")
     * 
     * @var string
     */
    private $category;
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $category
     */
    public function getCategory()
    {
        return $this->category;
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
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

}

