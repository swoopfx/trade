<?php
namespace General\Service;

use User\Entity\UserProfile;
use Laminas\Authentication\AuthenticationService;

class GeneralService
{

    const APP_NAME = "TFITS RETAILER";

    const APP_COMPANY_NAME = 'TANIM FITS';
    
   const BASE_MAIL = "tfits.online";
    
    const COMPANY_EMAIL = "";
    
    const  COMPANY_SUPPORT_EMAIL = "support@tanimfits.com.ng";
    
    const COMPANY_TECH_EMAIL = "help@tanimfits.com.ng";
    
    const COMPANY_ADDRESS = " 15 Jacob adeleye Street";
    
    const COMPANY_PHONE = "+234 8038558458";
    
    const COMPANY_URL ="https://app.tanimfits.com.ng";
    
    const USER_LEVEL_BEGINNER = 10;
    
    const SESSION_TRAINING = "training_session";
    
    const CART_PRODUCT_HOME_DELIVERY = 100;
    
    const CART_PRODUCT_PICK_UP = 10 ;
    
    const COMPANY_PORTAL_URL = "https://portal.tanimfits.com.ng";
    
    const COMPANY_APP_PRIVACY_POLICY = '';
    
    const COMPANY_RETURN_POLICY = '';
    
    const COMPANY_CANCEL_ORDER_POLICY = '';
       
    const ADD_8_DAYS = "P8D";

    private $entityManager;
    
    private $odm;

    private $auth;

    private $generalSession;

    private $userId;

    private $renderer;

    private $shopppingSession;
    
    private  $mailService;
    
    
    /**
     * @return the $mailService
     */
    public function getMailService()
    {
        
        return $this->mailService;
    }

    /**
     * @param field_type $mailService
     */
    public function setMailService($mailService)
    {
        $this->mailService = $mailService;
        return $this;
    }

    /**
     * This function is used to send mails form any controller or service
     * If there is going to be a complex AddCC or addBcc Request,It should be done in the controller
     *
     * @param array $messagePointers
     * @param array $template
     */
    public function sendMails($messagePointers = array(), $template = array(), $replyTo = "", $addCc = "", $addBcc = "")
    {
        
        $mailService = $this->mailService;
        // $der = new Message();
        $message = $mailService->getMessage();
        $message->SetTo($messagePointers['to'])
        ->setFrom(self::COMPANY_TECH_EMAIL, ($messagePointers['fromName'] == NULL ? self::APP_COMPANY_NAME : $messagePointers["fromName"]))
        ->setSubject($messagePointers['subject']);
        
        if ($replyTo != "") {
            $message->setReplyTo($replyTo);
        }
        
        if ($addCc != "") {
            $message->addCc($addCc);
        }
        
        if ($addBcc != "") {
            $message->addBcc($addBcc);
        }
        
        $mailService->setTemplate($template['template'], $template['var']);

        $mailService->send();

    }
    
    
    public static function standard_object_to_array($data){
        if(is_object($data)){
            $data = get_object_vars($data);
            return $data;
        }else{
            return $data;
        }
    }

    /**
     * This functions the firstname of the user
     * 
     * @return string
     */
    public function getFirstName()
    {
        if (isset($this->userId)) {
            $em = $this->entityManager;
            /**
             *
             * @var UserProfile $profileEntity
             */
            $profileEntity = $em->find("User\Entity\UserProfile", $this->userId);
            return $profileEntity->getFirstname();
        }
    }
    
    public static function noDataHelper($data){
        return $data ?? "<strong>No Data</strong>";
    }
    
    public static function spine($string){
        return strip_tags(str_replace(" ", "-", $string));
       
    }
    
    public static function string2Booleean($data){
        $type = gettype($data);
        if($type == "string"){
            return ($data == "false" ? false : true);
        }
    }

    /**
     * This function returns the lastname of the user
     * 
     * @return string
     */
    public function getLastName()
    {
        if (isset($this->userId)) {
            $em = $this->entityManager;
            /**
             *
             * @var UserProfile $profileEntity
             */
            $profileEntity = $em->find("User\Entity\UserProfile", $this->userId);
            return $profileEntity->getLastname();
        }
    }

    /**
     *
     * @return mixed
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     *
     * @param mixed $entityManager            
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     *
     * @return AuthenticationService
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     *
     * @param mixed $auth            
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
        return $this;
    }

    /**
     *
     * @return mixed
     */
    public function getGeneralSession()
    {
        return $this->generalSession;
    }

    /**
     *
     * @param mixed $generalSession            
     */
    public function setGeneralSession($generalSession)
    {
        $this->generalSession = $generalSession;
        return $this;
    }

    /**
     *
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     *
     * @param mixed $userId            
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     *
     * @return mixed
     */
    public function getUserEntity()
    {
        return $this->userEntity;
    }

    /**
     *
     * @param mixed $userEntity            
     */
    public function setUserEntity($userEntity)
    {
        $this->userEntity = $userEntity;
        return $this;
    }

    /**
     *
     * @return the $renderer
     */
    public function getRenderer()
    {
        return $this->renderer;
    }

    /**
     *
     * @param field_type $renderer            
     */
    public function setRenderer($renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }
    /**
     * @return the $shopppingSession
     */
    public function getShopppingSession()
    {
       
        return $this->shopppingSession;
    }

    /**
     * @param field_type $shopppingSession
     */
    public function setShopppingSession($shopppingSession)
    {
        $this->shopppingSession = $shopppingSession;
        return $this;
    }
    /**
     * @return the $odm
     */
    public function getOdm()
    {
        return $this->odm;
    }

    /**
     * @param field_type $odm
     */
    public function setOdm($odm)
    {
        $this->odm = $odm;
        return $this;
    }


}

