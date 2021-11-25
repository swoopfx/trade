<?php
namespace General\Paginator;

use Laminas\Paginator\Adapter\AdapterInterface;
use Doctrine\ORM\EntityRepository;

/**
 *
 * @author otaba
 *        
 */
class Adapter implements AdapterInterface
{
    
    /**
     * 
     * @var EntityRepository
     */
    protected $repository;
    
    public function __construct(EntityRepository $repository){
        $this->repository = $repository;
    }
    
    /**
     * {@inheritDoc}
     * @see \Laminas\Paginator\Adapter\AdapterInterface::getItems()
     */
    public function getItems($offset, $itemCountPerPage)
    {
//         return $this->repository->getItems($offset, $itemCountPerPage);
        
    }

    /**
     * {@inheritDoc}
     * @see Countable::count()
     */
    public function count($criteria = NULL)
    {
        return $this->repository->count($criteria);
        
    }
    
    
    public function setRepository($repo){
        $this->repository = $repo;
        return $this;
    }


   
}

