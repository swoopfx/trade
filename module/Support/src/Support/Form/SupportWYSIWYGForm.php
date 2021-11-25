<?php
namespace Support\Form;

use Laminas\Form\Form;

/**
 *
 * @author otaba
 *        
 */
class SupportWYSIWYGForm extends Form
{

    public function init(){
        $this->setAttributes(array(
            "id" => "simpleForm",
            "method" => "POST",
            "class" => "ajax_element"
            
        ));
        
        $this->add(array(
            "name"=>"wysiwygFieldset",
            "type"=>"Support\Form\Fieldset\SupportWYSIWYGFieldset",
            "options"=>array(
                "use_as_base_fieldset"=>true
            )
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Laminas\Form\Element\Submit',
            'attributes' => array(
                // 'type' => 'submit',
                'value' => 'Complete Profile',
                'class' => 'btn btn-primary bd-0'
                
            )
        ));
    }
}

