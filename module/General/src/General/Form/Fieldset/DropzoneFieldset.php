<?php
namespace General\Form\Fieldset;

use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;

/**
 *
 * @author otaba
 *        
 */
class DropzoneFieldset extends Fieldset implements InputFilterProviderInterface
{

   public function init(){
       $this->add(array());
   }
    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\InputFilter\InputFilterProviderInterface::getInputFilterSpecification()
     *
     */
    public function getInputFilterSpecification()
    {
        
        return array(
            
        );
    }
}

