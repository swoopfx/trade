<?php
namespace Wallet\Service;

use Wallet\Entity\Credit;

/**
 *
 * @author otaba
 *        
 */
class CreditService
{

//     const USER_CREDIT_LIMIT = "20000";

    private $entityManager;

    private $generalService;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    public function getAvaiableCreditLimit($userId){
        
       
        $em = $this->entityManager;
        /**
         * 
         * @var Credit $creditEntity
         */
        $creditEntity = $em->getRepository(Credit::class)->findOneBy(array(
            "user"=>$userId
        ));
       
        if(isset($creditEntity)){
            return $creditEntity->getCreditLimit();
        }else{
            return "0";
        }

        return "0";
       
    }
    
    /**
     * 
     * @param string $userId
     * @return \Wallet\Entity\the|string
     */
    public function getCreditBonus($userId){
        $em = $this->entityManager;
        
        /**
         *
         * @var Credit $creditEntity
         */
        $creditEntity = $em->getRepository("Wallet\Entity\Credit")->findOneBy(array(
            "user"=>$userId
        ));
        if(isset($creditEntity)){
            return $creditEntity->getCreditBonus();
        }else{
            return "0";
        }
    }
    
    public static function generateCreditUid(){
        $const = "credit";
        $code = \uniqid($const);
        return $code;
    }
    /**
     * @return the $entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @return the $generalService
     */
    public function getGeneralService()
    {
        return $this->generalService;
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
     * @param field_type $generalService
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return  $this;
    }

    
    
}

