<?php
namespace General\Form;

use Laminas\Form\Form;

/**
 *
 * @author otaba
 *        
 */
class DropzoneForm extends Form
{

   public function init(){
       $this->setAttributes(array(
           "class"=>"dropzone needsclick",
           "method"=>"POST",
           // "action"=>"gooo",
           // "id"=>"dropzone"
       ));
       
       $this->add(array(
           "name"=>"upload",
           "type"=>"submit",
           "options"=>array(),
           'attributes' => array(
               'value' => 'Upload',
               "class" => "btn btn-block btn-primary"
           )
       )); 
   }
}

