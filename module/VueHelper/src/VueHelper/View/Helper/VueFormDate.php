<?php
namespace VueHelper\View\Helper;

use Laminas\Form\View\Helper\FormDate;

/**
 *
 * @author otaba
 *        
 */
class VueFormDate extends FormDate
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

