<?php
namespace Settings\Service;

use Doctrine\ORM\EntityManager;
use General\Service\GeneralService;
use Settings\Entity\ShopDetails;

/**
 *
 * @author otaba
 *        
 */
class SettingsService
{
    
    const GARMENT_SIZE_CATEGORY_US = 20;
    
    const GARMENT_SIZE_CATEGORY_UK = 10;
    
    const GARMENT_SIZE_CATEGORY_EU = 30;
    
    const GARMENT_SIZE_CATEGORY_CHINA = 50;

    /**
     * 
     * @var EntityManager
     */
    private $entityManager;

    /**
     * 
     * @var GeneralService
     */
    private $generalService;

    // TODO - Insert your code here
    
    /**
     * 
     * @return array|NULL
     */
    public function getShopAdress(){
        $details = array();
        $data = NULL;
        $em = $this->entityManager;
        /**
         * 
         * @var ShopDetails $shopDetailsEntity
         */
        $shopDetailsEntity = $em->find("Settings\Entity\ShopDetails", "1");
        if($shopDetailsEntity != NULL){
            $details["email"] = $shopDetailsEntity->getEmail();
            $details['phone'] = $shopDetailsEntity->getPhone();
            $details['fulladdress'] = $shopDetailsEntity->getFulladdress();
            $details["terms"] = $shopDetailsEntity->getTerms();
            $details["shipping"] = $shopDetailsEntity->getShippingInfo();
            $details["return"] = $shopDetailsEntity->getReturnPolicy();
            $details["privacy"] = $shopDetailsEntity->getPrivacyPolicy();
            
            return $details;
            
        }else{
            return NULL;
        }
    }
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * @param \General\Service\GeneralService $generalService
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return $this;
    }

}

