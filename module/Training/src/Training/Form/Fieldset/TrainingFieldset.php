<?php
namespace Training\Form\Fieldset;

use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Training\Entity\Training;
use Doctrine\ORM\EntityManager;

/**
 *
 * @author otaba
 *        
 */
class TrainingFieldset extends Fieldset implements InputFilterProviderInterface
{
    /**
     *
     * @var string
     */
    private $labelClassAttributes;
    
    /**
     *
     * @var string
     */
    private $classAttributes;
    
    /**
     * 
     * @var EntityManager
     */
    private $entityManager;
    

    public function init(){
        $this->labelClassAttributes = "col-md-3 col-form-label text-md-right";
        $this->classAttribute = "form-control";
        
        $hydrator = new DoctrineObject($this->entityManager);
        $this->setObject(new Training())->setHydrator($hydrator);
        
        $this->add(array(
            "name"=>"trainingTopic",
            "type"=>"text", 
            "options"=>array(
                "label"=>"Training Topic",
                "labe_attributes"=>array(
                    "class"=>$this->labelClassAttributes
                )
            ),
            "attributes"=>array(
                "class"=>$this->classAttributes,
                "id"=>"trainingTopic",
                ":change"=>"handleTrainingTopic()",
                "ref"=>"trainingTopic",
                "required"=>"required",
                "data-parsley-required" => "true",
//                 "placeholder"=>"Men"
            )
        ));
        
        $this->add(array(
            "name"=>"trainingDescription",
            "type"=>"textarea",
            "options"=>array(
                "label"=>"Training Description",
                "labe_attributes"=>array(
                    "class"=>$this->labelClassAttributes
                )
            ),
            "attributes"=>array(
                "class"=>$this->classAttributes,
                "id"=>"trainingDescription",
                ":change"=>"handleTrainingDescription()",
                "ref"=>"trainingDescription",
                "required"=>"required",
                "data-parsley-required" => "true",
                //                 "placeholder"=>"Men"
            )
        ));
        
        $this->add(array(
            "name"=>"image",
            "type"=>"file",
            "options"=>array(
                "label"=>"Training Banner",
                "label_attributes"=>array(
                    "class"=>$this->labelClassAttributes
                )
            ),
            "attributes"=>array(
                "class"=>$this->classAttributes,
                "id"=>"image",
                "required"=>"required",,
                "data-parsley-required" => "true",
            ),
        ));
        
        $this->add(array(
            "name"=>"trainingPoints",
            "type"=>"number",
            "options"=>array(
                "label"=>"Training Points",
                "labe_attributes"=>array(
                    "class"=>$this->labelClassAttributes
                )
            ),
            "attributes"=>array(
                "class"=>$this->classAttributes,
                "id"=>"trainingTopic",
                "min"=>0,
                "max"=> 10,
                "value"=>0,
                "required"=>"required",
                "data-parsley-required" => "true",
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
        
        return array(
            "trainingPoints"=>array(
                "required"=>true,
                "allow_empty"=>false,
            ),
            "image"=>array(
                "required"=>true,
                "allow_empty"=>false,
            ),
            
            "trainingDescription"=>array(
                "required"=>true,
                "allow_empty"=>false,
            ),
            
            "trainingTopic"=>array(
                "required"=>true,
                "allow_empty"=>false,
            ),
            
        );
    }
    /**
     * @return the $entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

}

