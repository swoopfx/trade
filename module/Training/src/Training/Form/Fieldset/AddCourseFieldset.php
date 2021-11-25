<?php
namespace Training\Form\Fieldset;

use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;

/**
 *
 * @author otaba
 *        
 */
class AddCourseFieldset extends Fieldset implements InputFilterProviderInterface
{

    
    public function init(){
//         $this->add($elementOrFieldset)
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\InputFilter\InputFilterProviderInterface::getInputFilterSpecification()
     *
     */
    public function getInputFilterSpecification()
    {
        
        // TODO - Insert your code here
    }
}

