<?php
namespace Bbmin\View\Helper\Customer;

use Laminas\View\Helper\AbstractHelper;
use CsnUser\Service\UserService;

/**
 *
 * @author otaba
 *        
 */
class BbminCustomerListActionButton extends AbstractHelper
{

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function __invoke($user){
        if(is_array($user)){
            $userStateId = $user["state"]["id"];
            $userEmailConfirmed = $user["emailConfirmed"];
            $userIsProfiled = $user["isProfiled"];
            if($userStateId == UserService::USER_STATE_DISABLED){
                return "";
            }else{
                if(!$userEmailConfirmed){
                    return "<span class='label label-danger '>Email Not Confirmed</span>";
                }elseif (!$userIsProfiled){
                    return "<label class='label label-danger'>No Profile</label>";
                }else{
                    return "<label class='label label-success'>Account Active</label>";
                }
            }
        }elseif (is_object($user)){
            $userStateId =  $user->getState()->getId();
        }else{
            
        }
    }
}

