<?php
namespace Shop\Service;

use Doctrine\ORM\EntityManager;
use Laminas\Authentication\AuthenticationService;

/**
 *
 * @author otaba
 *        
 */
class ShopDashboardService
{

    /**
     *
     * @var EntityManager
     *
     */
    private $entityManager;

    /**
     *
     * @var AuthenticationService
     */
    private $auth;

    /**
     *
     * @var string
     */
    private $userId;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    /**
     * This gets the entity for the shop dashboard carousel
     * @return \Doctrine\Persistence\object[]|array|NULL
     */
    public function getShopDashboardMainCarourel(){
        $em = $this->entityManager;
        $entity = $em->getRepository("Shop\Entity\ShopHomeMainCarousel")->findAll();
        if($entity != NULL){
            return $entity;
        }else{
            return NULL;
        }
    }
    
    /**
     * This function gets the entity for the splash shop home page 
     * @return object|NULL|NULL
     */
    public function getShopDashboardSplash(){
       $em = $this->entityManager;
       $entity = $em->find("Shop\Entity\ShopHomeSplashRow", 1);
       if($entity != NULL){
           return $entity;
       }else{
           return NULL;
       }
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
     * @param \Laminas\Authentication\AuthenticationService $auth
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
        return $this;
    }

    /**
     * @param string $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

}

