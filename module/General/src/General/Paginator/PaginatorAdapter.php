<?php
namespace General\Paginator;

/**
 *
 * @author mac
 *        
 */

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter ;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Laminas\Paginator\Paginator;

class PaginatorAdapter
{

    // TODO - Insert your code here
    
    private $query;
    
   
    
    private $adapter;
    
    
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    public function setQuery($query){
        $this->query = $query;
        return $this;
    }
    
    public function createPaginator(){
        $adapter = new DoctrineAdapter(new ORMPaginator($this->query, false));
        $paginator = new Paginator($adapter);
        return $paginator;
    }
    
    
   
}

