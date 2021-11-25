<?php
namespace Shop\View\Helper\Form;

use Laminas\Form\View\Helper\FormCheckbox;

/**
 *
 * @author otaba
 *        
 */
class CheckboxVueHelper extends FormCheckbox
{
    
    
    
    
   public function __construct(){
       $this->addValidAttributePrefix("v-");
       $this->addValidAttributePrefix(":");
   }
}

