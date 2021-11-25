<?php
namespace VueHelper\View\Helper;

use Laminas\Form\View\Helper\FormCheckbox;

/**
 *
 * @author otaba
 *        
 */
class VueFormCheckbox extends FormCheckbox
{
    
    public function __construct(){
        $this->addValidAttributePrefix(":");
        $this->addValidAttributePrefix("v-");
        $this->addValidAttributePrefix("v-bind:");
        $this->addValidAttributePrefix("@");
        $this->addValidAttributePrefix("ref");
        $this->addValidAttributePrefix("v-model");
    }
}

