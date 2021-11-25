<?php
namespace Shop\Form;

use Laminas\Form\Form;

/**
 *
 * @author otaba
 *        
 */
class ProductForm extends Form
{
    
    public function init(){
        $this->setAttributes(array(
            "class"=>"form-control-with-bg",
            "POST"=>"",
            "autocomplete"=>"off",
            "name"=>"form-wizard",
//             "id"=>"addProduct"
        ));
        
        
        $this->add(array(
            "name"=>"productFieldset",
            "type"=>"Shop\Form\Fieldset\ProductFieldset",
            'options'=>array(
                'use_as_base_fieldset'=>true,
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
            'name' => 'reset',
            'type' => 'Laminas\Form\Element',
            'options' => array()
            
            ,
            'attributes' => array(
                'class' => 'btn btn-primary',
                'value' => 'Reset',
                'id' => 'reset'
            )
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'button',
            'attributes' => array(
                'type' => 'button',
                'value' => 'Submit Product',
                'class' => 'btn btn-success btn-primary',
                "@click"=>"onSubmitProduct()"
                
            )
        ));
    }
}

