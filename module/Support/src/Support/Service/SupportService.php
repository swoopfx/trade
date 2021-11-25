<?php
namespace Support\Service;

use Doctrine\ORM\EntityManager;
use Laminas\Authentication\AuthenticationService;
use Support\Entity\Support;
use Doctrine\ORM\AbstractQuery;
use Laminas\Session\Container;

/**
 *
 * @author otaba
 *        
 */
class SupportService
{
    
    const SUPPORT_STATUS_INITIATED= 10;
    
    const SUPPORT_STATUS_CLOSED = 100;
    
    const SUPPORT_STATUS_PROCESSING = 50;
    
    
    const SUPPORT_MESSAGE_STATE_SENDER = 50;
    
    const SUPPORT_MESSAGE_STATE_RECEIVER = 10;
    

    /**
     *
     * @var EntityManager
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
     * 
     * @var Container
     */
    private $messageSession;

//     public function getSupportEntity()
//     {
//         $em = $this->entityManager;
//         if ($this->userId != NULL) {
//             $supportEntity = $em->getRepository()->findOneBy(array(
//                 "user" => $this->userId
//             ));
//             if ($supportEntity != NULL) {
//                 return $supportEntity;
//             } else {
//                 $supportEntity = new Support();
//                 $supportEntity->setCreatedOn(new \DateTime())
//                     ->setIsActive(False)
//                     ->setSupportUid(SupportService::generateSupportUid())
//                     ->setUser($em->find("CsnUser\Entity\User", $this->userId))->set;
//             }
//         }
//     }

    
   /**
    * 
    * @return \Doctrine\ORM\QueryBuilder
    */
    private function getUserSupportTicket(){
        if($this->userId != NULL){
            $limit= 50;
            $em = $this->entityManager;
            /**
             *
             * @var \Doctrine\ORM\QueryBuilder $qb
             */
            $qb = $em->createQueryBuilder();
            $qb->select("s")->from("Support\Entity\Support", "s")->setMaxResults($limit)->orderBy("s.updatedOn", "DESC");
            
           return $qb;
        }
    }
    
   /**
    * 
    * @return mixed|\Doctrine\DBAL\Driver\Statement|array|NULL
    */
    public function getUserRecentSupportTicketObject(){
        if($this->userId != NULL){
           $qb = $this->getUserSupportTicket();
           return $qb->getQuery()->getResult();
        }
    }
    
    /**
     * 
     * @return mixed|\Doctrine\DBAL\Driver\Statement|array|NULL
     */
    public function getUserRecentSupportTicketArray(){
        if($this->userId != NULL){
            $qb = $this->getUserSupportTicket();
            return $qb->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);
        }
    }

    public static function generateSupportUid()
    {
        return uniqid(rand());
    }

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    /**
     *
     * @param \Doctrine\ORM\EntityManager $entityManager            
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     *
     * @param \Laminas\Authentication\AuthenticationService $auth            
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
        return $this;
    }

    /**
     *
     * @param string $userId            
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }
    /**
     * @return the $messageSession
     */
    public function getMessageSession()
    {
        return $this->messageSession;
    }

    /**
     * @param \Laminas\Session\Container $messageSession
     */
    public function setMessageSession($messageSession)
    {
        $this->messageSession = $messageSession;
        return $this;
    }

}

