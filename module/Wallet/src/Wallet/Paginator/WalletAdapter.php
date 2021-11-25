<?php
namespace Wallet\Paginator;

use Laminas\Paginator\Adapter\AdapterInterface;
use Wallet\Entity\Repository\WalletRepository;

/**
 *
 * @author otaba
 *        
 */
class WalletAdapter implements AdapterInterface
{
    
    /**
     * @var WalletRepository
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
        return $this->repository->count();
        
    }
    /**
     * @param \Wallet\Entity\Repository\WalletRepository $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
        return $this;
    }




}

