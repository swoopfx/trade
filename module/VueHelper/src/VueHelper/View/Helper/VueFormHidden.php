<?php
namespace VueHelper\View\Helper;

use Laminas\Form\View\Helper\FormHidden;

/**
 *
 * @author mac
 *        
 */
class VueFormHidden extends FormHidden
{

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
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

