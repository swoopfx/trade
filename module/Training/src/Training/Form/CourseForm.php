<?php
namespace Training\Form;

use Laminas\Form\Form;

/**
 *
 * @author otaba
 *        
 */
class CourseForm extends Form
{

    // TODO - Insert your code here
    
   public function init(){
       $this->setAttributes(array(
           "class"=>"form-horizontal",
           "method"=>"POST",
           "data-parsley-validate"=>"true"
       ));
       
       $this->add(array(
           "name"=>"courseFieldset",
           'type'=>"Training\Form\Fieldset\CourseFieldset",
           "options"=>array(
               "use_as_base_fieldset"=>true
           )
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
       //        $this->add(array(
       //            'name' => 'reset',
       //            'type' => 'Laminas\Form\Element',
       //            'options' => array()
       
       //            ,
       //            'attributes' => array(
       //                'class' => 'btn btn-primary',
       //                'value' => 'Reset',
       //                'id' => 'reset'
       //            )
       //        ));
       
       $this->add(array(
           'name' => 'submit',
           'type' => 'Laminas\Form\Element\Submit',
           'attributes' => array(
               'type' => 'submit',
               'value' => 'Create Course',
               'class' => 'btn btn-success btn-primary',
               
           )
       ));
   }
}

