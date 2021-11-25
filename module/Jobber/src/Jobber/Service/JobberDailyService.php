<?php
namespace Jobber\Service;

/**
 *
 * @author otaba
 *        
 */
class JobberDailyService
{

    private $entityManager;
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    /**
     * @param field_type $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

}

