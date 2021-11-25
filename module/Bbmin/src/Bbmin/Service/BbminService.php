<?php
namespace Bbmin\Service;

/**
 *
 * @author otaba
 *        
 */
class BbminService
{

    private $entityManager;
    
    private $addProductSession;
    
    const BBMIN_ADD_PRODUCT_SESSION_KEY = 'addProductSession';
    
    const BBMIN_SUBMMITED_ASSIGMENT_STATUS_INITIATED = 10;
    
    const BBMIN_SUBMMITED_ASSIGMENT_STATUS_PROCESSING = 20;
    
    const BBMIN_SUBMMITED_ASSIGMENT_STATUS_COMPLETED = 30;
    
    const BBMIN_SUBMMITED_ASSIGMENT_STATUS_DISBURSED = 50;
    
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

    /**
     * @param field_type $addProductSession
     */
    public function setAddProductSession($addProductSession)
    {
        $this->addProductSession = $addProductSession;
        return $this;
    }
    /**
     * @return the $addProductSession
     */
    public function getAddProductSession()
    {
        return $this->addProductSession;
    }


}

