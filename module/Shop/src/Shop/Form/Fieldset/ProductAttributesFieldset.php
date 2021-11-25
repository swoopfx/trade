<?php
namespace Shop\Form\Fieldset;

use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Shop\Entity\ProductAttribute;

/**
 *
 * @author otaba
 *        
 */
class ProductAttributesFieldset extends Fieldset implements InputFilterProviderInterface
{
    private $entityManager;
    
    public function init(){
        $hydrator = new DoctrineObject($this->entityManager);
        $this->setObject(new ProductAttribute())->setHydrator($hydrator);
        
        $this->add(array(
            "name"=>"attributeName",
            "type"=>"text",
            "options"=>array(
                "label"=>"Attrribute Name",
                "label_attributes"=>array(
                    "class"=>"col-md-3 col-form-label text-md-right"
                ),
            ),
            "attributes"=>array(
                "class"=>"form-control",
                "id"=>"attributeName",
                "ref"=>"attributeName",
                // "v-model"=>"attributeName"
            )
        ));
        
        $this->add(array(
            "name"=>"attributetext",
            "type"=>"textarea",
            "options"=>array(
                "label"=>"Attrribute Description",
                "label_attributes"=>array(
                    "class"=>"col-md-3 col-form-label text-md-right"
                ),
            ),
            "attributes"=>array(
                "class"=>"form-control",
                "rows"=>10,
                "id"=>"attributetext",
                "ref"=>"attributetext",
                // "v-model"=>"attributetext",
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
    
    
    public function setEntityManager($em){
        $this->entityManager = $em;
        return $this;
    }
}

