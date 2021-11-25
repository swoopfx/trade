<?php
namespace User\Form;

use Laminas\Form\Form;

/**
 *
 * @author otaba
 *        
 */
class UserProfileForm extends Form
{

    public function init()
    {
        $this->setAttributes(array(
            "action" => "",
            "id" => "simpleForm",
            "method" => "POST",
            "class" => "ajax_element"
        ));
        
        $this->add(array(
            "name" => "userProfileFieldset",
            "type" => "User\Form\Fieldset\UserProfileFieldset",
            "options" => array(
                "use_as_base_fieldset" => true
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

