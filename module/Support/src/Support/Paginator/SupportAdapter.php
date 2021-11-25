<?php
namespace Support\Paginator;



use Laminas\Paginator\Adapter\AdapterInterface;

/**
 *
 * @author otaba
 *        
 */
class SupportAdapter implements AdapterInterface
{

   
    /**
     * {@inheritDoc}
     * @see \Laminas\Paginator\Adapter\AdapterInterface::getItems()
     */
    public function getItems($offset, $itemCountPerPage)
    {
        
        
    }

    /**
     * {@inheritDoc}
     * @see Countable::count()
     */
    public function count()
    {
        // TODO Auto-generated method stub
        
    }

}

