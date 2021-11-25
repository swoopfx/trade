<?php
namespace Bbmin\Service;

use Doctrine\ORM\EntityManager;
use General\Service\GeneralService;

/**
 *
 * @author ezekiel
 *        
 */
class ShopboardService
{
    
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
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    /**
     * @return the $entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
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
     * @return the $generalService
     */
    public function getGeneralService()
    {
        return $this->generalService;
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

