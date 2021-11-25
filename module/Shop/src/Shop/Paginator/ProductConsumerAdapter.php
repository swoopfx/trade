<?php
namespace Shop\Paginator;

use Laminas\Paginator\Adapter\AdapterInterface;
use Shop\Entity\Repository\ProductRepository;

/**
 *
 * @author otaba
 *        
 */
class ProductConsumerAdapter implements AdapterInterface
{

    /**
     * 
     * @var ProductRepository
     */
    private $repository;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Laminas\Paginator\Adapter\AdapterInterface::getItems()
     */
    public function getItems($offset, $itemCountPerPage)
    {
        return $this->repository->getPublishedProductObject($offset, $itemCountPerPage);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see Countable::count()
     */
    public function count()
    {
        return $this->repository->publishedCountObject();
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

