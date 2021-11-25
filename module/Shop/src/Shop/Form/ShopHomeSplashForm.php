<?php
namespace Shop\Form;

use Laminas\Form\Form;

/**
 *
 * @author otaba
 *        
 */
class ShopHomeSplashForm extends Form
{
    
    public function init(){
        $this->setAttributes(array(
            "method"=>"POST",
            "class"=>""
        ));
        
        $this->add(array(
            "name"=>"shopHomeSplashFieldset",
            "type"=>"Shop\Form\Fieldset\ShopHomeSplashFieldset",
            "options"=>array(
                'use_as_base_fieldset' => true
            ),
        ));
        
        $this->add(array(
            'name' => 'csrf',
            'type' => 'Laminas\Form\Element\Csrf',
            'options' => array(
                'csrf_options' => array(
                    'timeout' => 5200
                )
            )
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Laminas\Form\Element\Submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'UPLOAD BANNER',
                'class' => 'btn btn-success btn-primary',
                
            )
        ));
    }
}

