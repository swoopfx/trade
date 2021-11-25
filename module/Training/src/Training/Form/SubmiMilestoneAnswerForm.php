<?php
namespace Training\Form;

use Laminas\Form\Form;

/**
 *
 * @author mac
 *        
 */
class SubmiMilestoneAnswerForm extends Form
{

    public function init(){
        $this->setAttributes(array(
            "class"=>"form-horizontal ajax_element",
            "id"=>"assignment",
            "method"=>"POST",
            "data-parsley-validate"=>"true",
            
        ));
        
        $this->add(array(
            "name"=>"submitMilestoneAnswerFieldset",
            'type'=>"Training\Form\Fieldset\SubmitMilestoneAnswerFieldset",
            "options"=>array(
                "use_as_base_fieldset"=>true
            )
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Laminas\Form\Element\Submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Submit Answer',
                'class' => 'btn btn-success btn-block btn-primary',
                
            )
        ));
    }
}

