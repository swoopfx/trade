<?php
namespace Support\Form;

use Laminas\Form\Form;

/**
 *
 * @author otaba
 *        
 */
class SupportForm extends Form
{

    public function init()
    {
        $this->setAttributes(array(
            "method"=>"POST"
        ));
        
       
        $this->add(array(
            "name" => "supportFieldset",
            "type" => "Support\Form\Fieldset\SupportFieldset",
            "options" => array(
                "use_as_base_fieldset" => true
            )
        ));
       
        $this->add(array(
            'name' => 'submit',
            'type' => 'Laminas\Form\Element\Submit',
            'attributes' => array(
                // 'type' => 'submit',
                'value' => 'SEND',
                'class' => 'btn btn-purple btn-block'
            
            )
        ));
        
       
    }
}

