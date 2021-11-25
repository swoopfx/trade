<?php
namespace Support\Form;

use Laminas\Form\Form;

/**
 *
 * @author otaba
 *        
 */
class SupportMessageForm extends Form
{

    public function init()
    {
        $this->setAttributes(array(
            "method" => "POST"
        ));
        
        $this->add(array(
            "name" => "supportMessageFieldset",
            "type" => "Support\Form\Fieldset\SupportMessageFieldset",
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

