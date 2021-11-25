<?php
namespace Shop\View\Helper\Form;

// use Laminas\Form\View\Helper\FormText;
use Laminas\Form\View\Helper\FormNumber;

/**
 *
 * @author otaba
 *        
 */
class TextVuehelper extends FormNumber
{
   
    
    public function __construct(){
        $this->addValidAttributePrefix(":");
        $this->addValidAttributePrefix("v-bind:");
    }
}

