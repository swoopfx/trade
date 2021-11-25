<?php
namespace Training\Form\Fieldset;

use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Training\Entity\Course;
use Doctrine\ORM\EntityManager;

/**
 *
 * @author otaba
 *        
 */
class CourseFieldset extends Fieldset implements InputFilterProviderInterface
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
        $this->setHydrator($hydrator)->setObject(new Course());
        
        $this->add(array(
            "name"=>"title",
            "type"=>"text",
            "options"=>array(
                "label"=>"Course Title",
                "label_attributes"=>array(
                    "class"=>$this->labelClassAttributes
                )
            ),
            "attributes"=>array(
                "class"=>$this->classAttributes,
                "id"=>"title",
                "placeholder"=>"Intro to Ethics",
                "ref"=>"courseTitle"
            )
        ));
        
        $this->add(array(
            "name"=>"courseCode",
            "type"=>"text",
            "options"=>array(
                "label"=>"Course Code",
                "label_attributes"=>array(
                    "class"=>$this->labelClassAttributes
                )
            ),
            "attributes"=>array(
                "class"=>"form-control",
                "id"=>"courseCode",
                "placeholder"=>"ETH101",
                "ref"=>"courseCode"
            )
        ));
        
        $this->add(array(
            "name"=>"video",
            "type"=>"url",
            "options"=>array(
                "label"=>"Video Link",
                "label_attributes"=>array(
                    "class"=>$this->labelClassAttributes
                )
            ),
            "attributes"=>array(
                "class"=>$this->classAttributes,
                "id"=>"video",
                "placeholder"=>"http://yu.be/werrrr",
                "ref"=>"courseVideo"
                
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
    /**
     * @param field_type $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

}

