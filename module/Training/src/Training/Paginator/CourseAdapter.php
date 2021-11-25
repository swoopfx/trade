<?php
namespace Training\Paginator;

use Laminas\Paginator\Adapter\AdapterInterface;

/**
 *
 * @author otaba
 *        
 */
class CourseAdapter implements AdapterInterface
{

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\Authentication\Adapter\AdapterInterface::authenticate()
     *
     */
    public function authenticate()
    {
        
        // TODO - Insert your code here
    }
    /**
     * {@inheritDoc}
     * @see \Laminas\Paginator\Adapter\AdapterInterface::getItems()
     */
    public function getItems($offset, $itemCountPerPage)
    {
        // TODO Auto-generated method stub
        
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

