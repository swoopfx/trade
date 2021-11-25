<?php
namespace VueHelper\View\Helper;

use Laminas\Form\View\Helper\FormMultiCheckbox;

/**
 *
 * @author otaba
 *        
 */
class VueFormMultiCheckbox extends FormMultiCheckbox
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

