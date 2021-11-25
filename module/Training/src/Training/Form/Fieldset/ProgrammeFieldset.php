<?php
namespace Training\Form\Fieldset;

use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Training\Entity\Programmes;

/**
 *
 * @author otaba
 *
 */
class ProgrammeFieldset extends Fieldset implements InputFilterProviderInterface
{

    private $entityManager;

    private $labelClassAttributes;
    
    private $classAttribute;
    
    public function init(){
        $this->labelClassAttributes = "col-md-3 col-form-label text-md-right";
        $this->classAttribute = "form-control";
        
        $hydrator = new DoctrineObject($this->entityManager);
        $this->setObject(new Programmes())->setHydrator($hydrator);
        $this->add(array(
            "name"=>"title",
            "type"=>"text",
            "options"=>array(
                "label"=>"Programme  Title",
                "labe_attributes"=>array(
                    "class"=>$this->labelClassAttributes
                )
            ),
            "attributes"=>array(
                "id"=>"title",
                "class"=>$this->classAttributes,
                "id"=>"title",
                ":change"=>"handleTrainingTopic()",
                "ref"=>"title",
                "required"=>"required",
                "data-parsley-required" => "true",
            ),
        ));
        
        $this->add(array(
            "name"=>"description",
            "type"=>"textarea",
            "options"=>array(
                "label"=>"Programme  Title",
                "labe_attributes"=>array(
                    "class"=>$this->labelClassAttributes
                )
            ),
            "attributes"=>array(
                "id"=>"title",
                "class"=>$this->classAttributes,
                "id"=>"title",
                ":change"=>"handleTrainingTopic()",
                "ref"=>"title",
                "required"=>"required",
                "data-parsley-required" => "true",
            ),
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


    public function setEntityManager($em){
        $this->entityManager = $em;
        return $this;
    }
}
