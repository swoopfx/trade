<?php
namespace VueHelper\View\Helper;

use Laminas\Form\View\Helper\FormTextarea;

/**
 *
 * @author otaba
 *        
 */
class VueFormTextArea extends FormTextarea
{
    public function __construct(){
        $this->addValidAttributePrefix(":");
        $this->addValidAttributePrefix("ref");
        $this->addValidAttributePrefix("v-");
        $this->addValidAttributePrefix("v-bind:");
        $this->addValidAttributePrefix("@");
    }
}

