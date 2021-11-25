<?php
namespace User\Form\Fieldset;

use Laminas\Form\Fieldset;
use Laminas\InputFilter\InputFilterProviderInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use User\Entity\UserProfile;
use DoctrineModule\Form\Element\ObjectSelect;

class UserProfileFieldset extends Fieldset implements InputFilterProviderInterface
{
    private $entityManager;

    public function init(){
        $hydrator = new DoctrineObject($this->entityManager);
        $this->setObject(new UserProfile())->setHydrator($hydrator);
        
        $this->add(array(
            "name"=>"firstname",
            "type"=>"text",
            "options"=>array(
                "label"=>"FirstName",
                "label_attributes"=>array(
                    "class"=>"col-sm-4 form-control-label"
                )
            ),
            "attributes"=>array(
                "class"=>"form-control",
                "id"=>"firstname",
                "placeholder"=>"Kunle",
                "required"=>"required",
            ),
        ));
        
        $this->add(array(
            "name"=>"lastname",
            "type"=>"text",
            "options"=>array(
                "label"=>"SurName",
                "label_attributes"=>array(
                    "class"=>"col-sm-4 form-control-label"
                )
            ),
            "attributes"=>array(
                "class"=>"form-control",
                "id"=>"lastname",
                "placeholder"=>"Ibrahim",
                "required"=>"required",
            ),
        ));
        
        $this->add(array(
            "name"=>"dob",
            "type"=>"date",
            "options"=>array(
                "label"=>"Date Of Birth",
                "label_attributes"=>array(
                    "class"=>"col-sm-4 form-control-label"
                )
            ),
            "attributes"=>array(
                "class"=>"form-control",
                "id"=>"dob",
//                 "placeholder"=>"Ibrahim",
                "required"=>"required",
            ),
        ));
        
        
//         $this->add(array(
//             "name"=>"bvn",
//             "type"=>"text",
//             "options"=>array(
//                 "label"=>"Bank Verification Number",
//                 "label_attributes"=>array(
//                     "class"=>"col-sm-4 form-control-label"
//                 )
//             ),
//             "attributes"=>array(
//                 "class"=>"form-control",
//                 "id"=>"bvn",
//                 "placeholder"=>"21000010",
//                 "required"=>"required",
//             ),
//         ));
        
        $this->add(array(
            "name"=>"address1",
            "type"=>"text",
            "options"=>array(
                "label"=>"Address",
                "label_attributes"=>array(
                    "class"=>"col-sm-4 form-control-label"
                )
            ),
            "attributes"=>array(
                "class"=>"form-control",
                "id"=>"address1",
//                 "placeholder"=>"21000010",
                "required"=>"required",
            ),
        ));
        
        $this->add(array(
            "name"=>"identityType",
            "type"=>"DoctrineModule\Form\Element\ObjectSelect",
            "options"=>array(
                "label"=>"Type Of Identity",
                "label_attributes"=>array(
                    "class"=>"col-sm-4 form-control-label",
                ),
                "object_manager"=>$this->entityManager,
                "target_class"=>"Settings\Entity\IdentityType",
                "property"=>"type",
                'empty_option' => '-- Select Identity Type --',
            ),
            "attributes"=>array(
                "class"=>"form-control",
                "id"=>"select2-b",
                "required"=>"required",
            )
        ));
        
        $this->add(array(
            "name"=>"state",
            "type"=>"DoctrineModule\Form\Element\ObjectSelect",
            "options"=>array(
                "label"=>"State",
                "label_attributes"=>array(
                    "class"=>"col-sm-4 form-control-label",
                ),
                "object_manager"=>$this->entityManager,
                "target_class"=>"Settings\Entity\Zone",
                "property"=>"name",
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(
                            'country' => 156
                        ),
                        'orderBy' => array(
                            'id' => 'ASC'
                        )
                    )
                ),
//                 'empty_option' => '-- Select State --',
            ),
            "attributes"=>array(
                "class"=>"form-control select2-show-search",
                "id"=>"state",
                "required"=>"required",
            )
        ));
        
        
        $this->add(array(
            "name"=>"country",
            "type"=>"DoctrineModule\Form\Element\ObjectSelect",
            "options"=>array(
                "label"=>"Country",
                "label_attributes"=>array(
                    "class"=>"col-sm-4 form-control-label",
                ),
                "object_manager"=>$this->entityManager,
                "target_class"=>"Settings\Entity\Country",
                "property"=>"name",
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(
                            'id' =>156 
                        ),
                        'orderBy' => array(
                            'id' => 'ASC'
                        )
                    )
                ),
                'disabled'=>'disabled',
//                 'empty_option' => '-- Select Country --',
            ),
            "attributes"=>array(
                "class"=>"form-control select2",
                "id"=>"country",
                "required"=>"required",
            )
        ));
        
        
        
        $this->add(array(
            "name"=>"identity",
            "type"=>"text",
            "options"=>array(
                "label"=>"Identity Number",
                "label_attributes"=>array(
                    "class"=>"col-sm-4 form-control-label"
                )
            ),
            "attributes"=>array(
                "class"=>"form-control",
                "id"=>"identity",
                "placeholder"=>"ABC12345",
//                 "required"=>"required",
            ),
        ));
    }
    public function getInputFilterSpecification()
    {
        return array(
            
        );
    }
    /**
     * @param mixed $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }


}

