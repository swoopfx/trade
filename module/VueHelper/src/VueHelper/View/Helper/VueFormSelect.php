<?php
namespace VueHelper\View\Helper;

use Laminas\Form\View\Helper\FormSelect;

/**
 *
 * @author otaba
 *        
 */
class VueFormSelect extends FormSelect
{
    public function __construct(){
        $this->addValidAttributePrefix(":");
        $this->addValidAttributePrefix("v-");
        $this->addValidAttributePrefix("v-bind:");
        $this->addValidAttributePrefix("ref");
        $this->addValidAttributePrefix("v-on:change");
        $this->addValidAttributePrefix("v-on:");
        $this->addValidAttributePrefix("v-model");
        $this->addValidAttributePrefix("@");
    }
}

