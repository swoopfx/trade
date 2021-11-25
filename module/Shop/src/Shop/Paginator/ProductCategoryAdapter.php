<?php
namespace Shop\Paginator;

use Laminas\Paginator\Adapter\AdapterInterface;
use Shop\Entity\Repository\ProductRepository;

/**
 *
 * @author otaba
 *        
 */
class ProductCategoryAdapter implements AdapterInterface
{

    /**
     *
     * @var ProductRepository
     */
    private $repository;

    /**
     *
     * @var int
     */
    private $catId;



    /**
     *
     * {@inheritdoc}
     *
     * @see \Laminas\Paginator\Adapter\AdapterInterface::getItems()
     */
    public function getItems($offset, $itemCountPerPage)
    {
        try{
        return $this->repository->getItemProductByCategory($this->catId, $offset, $itemCountPerPage);
        }catch(\Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see Countable::count()
     */
    public function count()
    {
        return $this->repository->productItemByCategoryCount($this->catId);
    }

    /**
     *
     * @param field_type $repository            
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
        return $this;
    }
    /**
     * @param number $catId
     */
    public function setCatId($catId)
    {
        $this->catId = $catId;
        return $this;
    }

}

