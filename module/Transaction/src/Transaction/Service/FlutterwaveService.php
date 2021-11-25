<?php
namespace Transaction\Service;

/**
 *
 * @author mac
 *        
 */
class FlutterwaveService
{

    // TODO - Insert your code here
    
    private $entityManager;
    
    private $flutterwaveConfig;
    
    
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    
    public function getPublicKey(){
        return ($this->flutterwaveConfig)["public_key"];
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
     * @param field_type $flutterwaveConfig
     */
    public function setFlutterwaveConfig($flutterwaveConfig)
    {
        $this->flutterwaveConfig = $flutterwaveConfig;
        return $this;
    }

}

