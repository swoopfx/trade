<?php
namespace Bbmin\View\Helper\Training;

use Laminas\View\Helper\AbstractHelper;

/**
 *
 * @author mac
 *        
 */
class BbminTrainingActivationActiveHelper extends AbstractHelper
{

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    
   public function __invoke(bool $isActive){
       if($isActive){
           return "<i class='fa fa-circle text-teal f-s-8 mr-2'></i>";
       }else{
           return "<i class='fa fa-circle text-red f-s-8 mr-2'></i>";
       }
   }
}

