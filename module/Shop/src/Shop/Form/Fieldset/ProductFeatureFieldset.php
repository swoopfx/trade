<?php
namespace Shop\Form\Fieldset;

use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Shop\Entity\ProductFeatures;

/**
 *
 * @author otaba
 *        
 */
class ProductFeatureFieldset extends Fieldset implements InputFilterProviderInterface
{

    private $entityManager;

    private $labelClassAttributes;

    private $classAttribute;

    public function init()
    {
        $this->labelClassAttributes = "col-md-4 col-form-label text-md-right";
        $this->classAttribute = "form-control";
        
        $hydrator = new DoctrineObject($this->entityManager);
        $this->setObject(new ProductFeatures())->setHydrator($hydrator);
        
        $this->add(array(
            "name" => "featureType",
            "type" => "DoctrineModule\Form\Element\ObjectSelect",
            "options" => array(
                "label"=>"Feature Type",
                
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes,
                    
                ),
                "object_manager" => $this->entityManager,
                'target_class' => "Settings\Entity\ProductFeatureType",
                "property" => "type"
            ),
            "attributes" => array(
                "class" => $this->classAttribute,
                "v-model"=>"productFeatureType",
                "ref"=>"productFeatureType",
//                 "v-bind:title"=>"productFeatureTitle",
                "id" => "featureType"
            
            )
        ));
        
        $this->add(array(
            "name" => "featurInfo",
            "type" => "textarea",
            "options" => array(
                "label"=>"Feature Details",
//                 ":label" => "input.featureDetails",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                )
            ),
            "attributes" => array(
//                 "id" => "featurInfo",

                "v-model"=>"productFeatureInfo",
                "rows"=>10,
                "ref"=>"productFeatureInfo",
                "class" => $this->classAttribute,
                "placeholder" => "Black "
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

    public function setEntityManager($em)
    {
        $this->entityManager = $em;
        return $this;
    }
}

