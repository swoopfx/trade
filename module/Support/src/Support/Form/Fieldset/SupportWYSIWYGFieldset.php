<?php
namespace Support\Form\Fieldset;

use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use CKEditorModule\Form\Element\CKEditor;
use CKEditorModule;

/**
 *
 * @author otaba
 *        
 */
class SupportWYSIWYGFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function init()
    {
       
       
       

        
        $this->add(array(
            "name" => "wysiwyg",
            "type" => "textarea",
            "options" => array(
//                 "label" => "",
//                 "label_attributes" => array(
//                     "class" => ""
//                 )
            ),
            "attributes" => array(
                "class" => "form-control",
                "id" => "wysiwyg",
//                 "cols"=>50,
                "rows"=>4
            )
        ));
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\InputFilter\InputFilterProviderInterface::getInputFilterSpecification()
     *
     */
    public function getInputFilterSpecification()
    {
        
        return array();
    }
}

