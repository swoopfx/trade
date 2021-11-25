<?php
namespace Bbmin\Paginator;

use Laminas\Paginator\Adapter\AdapterInterface;
use CsnUser\Entity\Repository\UserRepository;

/**
 *
 * @author otaba
 *        
 */
class CustomerAdapter implements AdapterInterface
{
    
    /**
     * 
     * @var UserRepository
     */
    protected $repository;

    

    
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
    /**
     * @param field_type $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
        return $this;
    }


}

