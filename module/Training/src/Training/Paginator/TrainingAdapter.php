<?php
namespace Training\Paginator;

use Laminas\Paginator\Adapter\AdapterInterface;
// use Training\Entity\Training;
use Training\Entity\Repository\TrainingRepository;

/**
 *
 * @author otaba
 *        
 */
class TrainingAdapter implements AdapterInterface
{

    /**
     * 
     * @var TrainingRepository
     */
    private $repository;
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
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
       
        return $this->repository->countTraining();
        
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

