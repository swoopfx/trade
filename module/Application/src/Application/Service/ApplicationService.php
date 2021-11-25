<?php
namespace Application\Service;

use Laminas\Authentication\AuthenticationService;
use Doctrine\ORM\EntityManager;
use CsnUser\Entity\User;
use User\Entity\UserProfile;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class ApplicationService
{

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
     * @var GeneralService
     */
    private $generalService;

    private $userId;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    /**
     * This function gets the welcome message for a specific user
     * Usually returns the firstname of the user
     *
     * @return string
     */
    public function nameOfUser()
    {
        $em = $this->entityManager;
        
        if ($this->auth->hasIdentity()) {
            $id = $this->userId;
            
            /**
             *
             * @var UserProfile $userProfile
             */
            $userProfile = $em->getRepository("User\Entity\UserProfile")->findOneBy(array(
                "user" => $id
            ));
            if ($userProfile != NULL) {
                return $userProfile->getFirstname();
            } else {
                return NULL;
            }
        }
    }

    /**
     * This function gets the username of the 
     * @return string|NULL
     */
    public function getUserFullName()
    {
        $em = $this->entityManager;
        if ($this->auth->hasIdentity()) {
            $id = $this->userId;
            
            /**
             *
             * @var UserProfile $userProfile
             */
            $userProfile = $em->getRepository("User\Entity\UserProfile")->findOneBy(array(
                "user" => $id
            ));
            if ($userProfile != NULL) {
                return ($userProfile->getLastname() != NULL ? $userProfile->getLastname() : "") . " " . ($userProfile->getFirstname() != NULL ? $userProfile->getFirstname() : "");
            } else {
                return NULL;
            }
        }
    }
    
    public function getUserName(){
        $em = $this->entityManager;
        $identity = $this->auth->getIdentity();
        if($identity != NULL){
            return $identity->getUsername();
        }else{
            return NULL;
        }
    }
    
    
    public function getUserAddress(){
        $em = $this->entityManager;
        $userId = $this->generalService->getUserId();
        
        if($userId != NULL){
            /**
             * 
             * @var UserProfile $profileEntity
             */
            $profileEntity = $em->getRepository("User\Entity\UserProfile")->findOneBy(array(
                "user"=>$userId
            ));
            return $profileEntity->getFullAddress();
        }
    }
    
    
    public function getUserProfileFromUsername($username){
//         $em = $this->entityManager
    }
    
    public function getUserProfile(){
       
        $em = $this->entityManager;
        $userId = $this->generalService->getUserId();
      
        if($userId != NULL){
            $profileEntity = $em->getRepository(UserProfile::class)->findOneBy(array(
                "user"=>$userId
            ));
            return $profileEntity;
        }
    }
    
    public function getUserBvn(){
        $em = $this->entityManager;
        $userId = $this->generalService->getUserId();
        
        if($userId != NULL){
            /**
             *
             * @var UserProfile $profileEntity
             */
            $profileEntity = $em->getRepository("User\Entity\UserProfile")->findOneBy(array(
                "user"=>$userId
            ));
            return ($profileEntity->getBvn() != NULL ? $profileEntity->getBvn() : "");
        }
    }
    
    public function getUserDob(){
        $today = new \DateTime();
        /**
         * 
         * @var UserProfile $profileEntity
         */
       $profileEntity = $this->getUserProfile();
       if($profileEntity != NULL){
           return ($profileEntity->getDob() != NULL ? $profileEntity->getDob() : $today);
       }
       
    }
    
    
    public function getUserIdentityType(){
        /**
         * 
         * @var UserProfile $profileEntity
         */
        $profileEntity = $this->getUserProfile();
        if($profileEntity != NULL){
            return ($profileEntity->getIdentityType() != NULL ? $profileEntity->getIdentityType()->getType() : "");
        }else{
            return "";
        }
    }
    
    
    public function getUserIdentity(){
        /**
         * 
         * @var UserProfile $profile
         */
        $profile = $this->getUserProfile();
        if($profile != NULL){
            return ($profile->getIdentity() != NULL ? $profile->getIdentity() : "");
        }else{
            return "";
        }
    }
    
    
    public function getUserLevel(){
        $em = $this->entityManager;
        $userId = $this->generalService->getUserId();
        
        if($userId != NULL){
            /**
             *
             * @var UserProfile $profileEntity
             */
            $profileEntity = $em->getRepository("User\Entity\UserProfile")->findOneBy(array(
                "user"=>$userId
            ));
            return ($profileEntity->getUserLevel() != NULL ? $profileEntity->getUserLevel()->getLevel() : "");
        }
    }

    /**
     *
     * @param field_type $entityManager            
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     *
     * @param field_type $generalService            
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return $this;
    }

    /**
     *
     * @return the $auth
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     *
     * @param field_type $auth            
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
        return $this;
    }

    /**
     *
     * @param field_type $userId            
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }
}

