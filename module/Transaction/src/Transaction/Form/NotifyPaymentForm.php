<?php
namespace Transaction\Form;

use Laminas\Form\Form;

/**
 *
 * @author mac
 *        
 */
class NotifyPaymentForm extends Form
{

    // TODO - Insert your code here
    
   public function init(){
       $this->setAttributes(array(
           "action" => "",
           "id" => "simpleForm",
           "method" => "POST",
           "class" => "ajax_element"
       ));
       
       $this->add(array(
           "name" => "notifyPaymentFieldset",
           "type" => "Transaction\Form\Fieldset\NotifyPaymentFieldset",
           "options" => array(
               "use_as_base_fieldset" => true
           )
       ));
       
       $this->add(array(
           'name' => 'submit',
           'type' => 'Laminas\Form\Element\Submit',
           'attributes' => array(
               // 'type' => 'submit',
               'value' => 'Send Notification',
               'class' => 'btn btn-primary bd-0'
               
           )
       ));
   }
}

