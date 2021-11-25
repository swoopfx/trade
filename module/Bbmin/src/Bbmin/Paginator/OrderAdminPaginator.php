<?php
namespace Bbmin\Paginator;

use Laminas\Paginator\Adapter\AdapterInterface;
use Shop\Entity\Repository\OrderRepository;

/**
 *
 * @author mac
 *        
 */
class OrderAdminPaginator implements AdapterInterface
{
    
    private $entityManager;
    
    /**
     * 
     * @var OrderRepository
     */
    private $orderRepository; 

    // TODO - Insert your code here
    
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
        return  $this->orderRepository->getAdminOrderItems($offset, $itemCountPerPage);
        
    }

    /**
     * {@inheritDoc}
     * @see Countable::count()
     */
    public function count()
    {
        return $this->orderRepository->count();
        
    }
    /**
     * @param field_type $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * @param \Shop\Entity\Repository\OrderRepository $orderRepository
     */
    public function setOrderRepository($orderRepository)
    {
        $this->orderRepository = $orderRepository;
        return $this;
    }


}

