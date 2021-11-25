<?php
namespace Shop\Form;

use Laminas\Form\Form;

/**
 *
 * @author otaba
 *        
 */
class ProductCategoryForm extends Form
{

    public function init(){
        $this->setAttributes(array(
            "class"=>"form-horizontal",
            "method"=>"POST",
            "data-parsley-validate"=>"true"
        ));
        
        $this->add(array(
            "name"=>"productCategoryFieldset",
            "type"=>"Shop\Form\Fieldset\ProductCategoryFieldset",
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
                'value' => 'ADD CATEGORY',
                'class' => 'btn btn-success btn-primary',
                
            )
        ));
    }
}

