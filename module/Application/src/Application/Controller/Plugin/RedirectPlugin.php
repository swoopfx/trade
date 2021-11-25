<?php
namespace Application\Controller\Plugin;

use Laminas\Mvc\Controller\Plugin\AbstractPlugin;
use Laminas\Authentication\AuthenticationService;
use CsnUser\Service\UserService;

/**
 *
 * @author otaba
 *        
 */
class RedirectPlugin extends AbstractPlugin
{

    /**
     * 
     * @var AuthenticationService
     */
    private $auth;

    private $redirect;

    // TODO - Insert your code here
    
    public function redirectToLogout()
    {
        if (! $this->auth->hasIdentity()) {
            
            $this->redirect->toRoute('logout');
        }
        
    }
    
    public function redirectCondition(){
       $this->redirectToLogout();
       $this->roleRedirection();
    }
    
    public function roleRedirection(){
        if($this->auth->hasIdentity()){
            $identity = $this->auth->getIdentity();
            $roleId= $identity->getRole()->getId();
            if($roleId == UserService::USER_ROLE_ADMIN){
                $this->redirect->toRoute("bbmin");
            }
        }
    }
    
    
    
    public function adminRedirection(){
        if($this->auth->hasIdentity()){
            $identity = $this->auth->getIdentity();
            $roleId= $identity->getRole()->getId();
            if($roleId != UserService::USER_ROLE_ADMIN){
                $this->redirect->toRoute("newproduct");
            }
        }
    }
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    /**
     * @return the $auth
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @return the $redirect
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    /**
     * @param field_type $auth
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
        return $this;
    }

    /**
     * @param field_type $redirect
     */
    public function setRedirect($redirect)
    {
        $this->redirect = $redirect;
        return $this;
    }

}

