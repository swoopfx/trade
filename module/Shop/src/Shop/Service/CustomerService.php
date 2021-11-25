<?php
namespace Shop\Service;

/**
 *
 * @author otaba
 *        
 */
class CustomerService
{
    
    private $entityManager;

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    
    /**
     * @param field_type $emntityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    
}

