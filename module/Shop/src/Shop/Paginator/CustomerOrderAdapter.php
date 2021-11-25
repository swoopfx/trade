<?php
namespace Shop\Paginator;

use Laminas\Paginator\Adapter\AdapterInterface;
use Shop\Entity\Repository\OrderRepository;

/**
 *
 * @author ezekiel
 *        
 */
class CustomerOrderAdapter implements AdapterInterface
{
    
    /**
     * 
     * @var OrderRepository
     */
    private $cartOrderRepository;
    
    private $userId;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\Paginator\Adapter\AdapterInterface::getItems()
     *
     */
    public function getItems($offset, $itemCountPerPage)
    {
        
        return $this->cartOrderRepository->customerOrederItems($this->userId, $offset, $itemCountPerPage);
        
    }

    /**
     * (non-PHPdoc)
     *
     * @see Countable::count()
     *
     */
    public function count()
    {
        
        return $this->cartOrderRepository->customerOrderCount($this->userId);
    }
    /**
     * @return the $cartOrderRepository
     */
    public function getCartOrderRepository()
    {
        return $this->cartOrderRepository;
    }

    /**
     * @param field_type $cartOrderRepository
     */
    public function setCartOrderRepository($cartOrderRepository)
    {
        $this->cartOrderRepository = $cartOrderRepository;
        return $this;
    }
    /**
     * @return the $userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param field_type $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }


}

