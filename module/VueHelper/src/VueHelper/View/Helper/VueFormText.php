<?php
namespace VueHelper\View\Helper;

use Laminas\Form\View\Helper\FormText;

/**
 *
 * @author otaba
 *        
 */
class VueFormText extends FormText
{
    public function __construct(){
        $this->addValidAttributePrefix(":");
        $this->addValidAttributePrefix("v-");
        $this->addValidAttributePrefix("ref");
        $this->addValidAttributePrefix("v-model"); 
        $this->addValidAttributePrefix("v-on:change");
        $this->addValidAttributePrefix("v-on:");
        $this->addValidAttributePrefix("v-bind:");
        $this->addValidAttributePrefix("@");
        $this->addValidAttributePrefix("@click");
    }
}

