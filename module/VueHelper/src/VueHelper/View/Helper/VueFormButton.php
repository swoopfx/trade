<?php
namespace VueHelper\View\Helper;

use Laminas\Form\View\Helper\FormButton;

/**
 *
 * @author otaba
 *        
 */
class VueFormButton extends FormButton
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

