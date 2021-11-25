<?php
namespace Wallet\Form;

use Laminas\Form\Form;

/**
 *
 * @author otaba
 *        
 */
class WalletReferalForm extends Form
{

   public function init(){
       
       $this->setAttributes(array(
           
       ));
       
       $this->add(array(
           "name"=>"walletReferalFieldset",
           "type"=>"Wallet\Form\Fieldset\WalletReferalFieldset",
           "options"=>array(
               "use_as_base_fieldset"=>true
           ),
       ));
       
       $this->add(array(
           'name' => 'submit',
           'type' => 'submit',
           'attributes' => array(
               'type' => 'submit',
               'value' => 'Submit',
               'class' => 'btn btn-xs btn-primary btn-block'
           )
       ));
   }
}

