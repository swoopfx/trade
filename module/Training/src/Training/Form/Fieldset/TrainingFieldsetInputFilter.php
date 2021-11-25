<?php
namespace Training\Form\Fieldset;

use Laminas\InputFilter\InputFilter;

/**
 *
 * @author otaba
 *        
 */
class TrainingFieldsetInputFilter extends InputFilter
{

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        $this->add([
            "name"=>"",
            "required"=>true,
            "validator"=>[
                
            ],
            "filters"=>[],
        ]);
    }
}

