<?php
namespace Training\Form\Fieldset;

use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Training\Entity\UserSubmittedTrainingAssignment;

/**
 *
 * @author mac
 *        
 */
class SubmitMilestoneAnswerFieldset extends Fieldset implements InputFilterProviderInterface
{
    
    private $entityManager;
    
    

    
    
    public function init(){
        $hydrator = new DoctrineObject($this->entityManager);
        $this->setObject(new UserSubmittedTrainingAssignment())->setHydrator($hydrator);
        
        $this->add([
            'name'=>"answerss", 
            "type"=>"textarea",
            "options"=>[
                'label'=>"Milestone Answer",
                "label_attributes"=>[
                    'class'=>'form-control-label'
                ]
            ],
            "attributes"=>[
                'id'=>"editor", 
                'class'=>"form-control",
                'rows'=>10
            ],
        ]);
        
        $this->add([
            "name"=>"milestone",
            "type"=>"hidden",
            "attributes"=>[
                "id"=>"milestone"
            ]
        ]);
        
        $this->add([
            "name"=>"trainingId",
            "type"=>"hidden",
            "attributes"=>[
                "id"=>"trainingId"
            ]
        ]);
        
        
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\InputFilter\InputFilterProviderInterface::getInputFilterSpecification()
     *
     */
    public function getInputFilterSpecification()
    {
        
         return [];
    }
    

    /**
     * @param field_type $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

}

