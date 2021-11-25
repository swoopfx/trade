<?php
namespace Shop\Paginator;

use Laminas\Paginator\Adapter\AdapterInterface;
// use Doctrine\ORM\EntityRepository;
use Shop\Entity\Repository\ProductRepository;

/**
 *
 * @author otaba
 *        
 */
class ProductAdapter implements AdapterInterface
{
    
    /**
     * 
     * @var ProductRepository
     */
    private $repository;

    
    /**
     * {@inheritDoc}
     * @see \Laminas\Paginator\Adapter\AdapterInterface::getItems()
     */
    public function getItems($offset, $itemCountPerPage)
    {
        return $this->repository->getItems($offset, $itemCountPerPage);
        
    }

    /**
     * {@inheritDoc}
     * @see Countable::count()
     */
    public function count()
    {
       return $this->repository->count();
        
    }
    
    
    public function setRepository($repo){
        $this->repository = $repo;
        return $this;
    }

}

