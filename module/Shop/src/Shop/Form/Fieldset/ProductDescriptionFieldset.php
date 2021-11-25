<?php
namespace Shop\Form\Fieldset;

use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Shop\Entity\ProductDescription;

/**
 *
 * @author otaba
 *        
 */
class ProductDescriptionFieldset extends Fieldset implements InputFilterProviderInterface
{
    private $entityManager;
    
    public function init(){
        $hydrator = new DoctrineObject($this->entityManager);
        $this->setObject(new ProductDescription())->setHydrator($hydrator);
        
        $this->add(array(
            "name"=>"productName",
            "type="=>"text",
            "options"=>array(
                "label"=>"Product Title",
                "label_attributes"=>array(
                    "class"=>"col-md-3 col-form-label text-md-right"
                )
            ),
            "attributes"=>array(
                "class"=>"form-control",
                "id"=>"productName",
                "placeholder"=>"White Peplum Top",
                "data-parsley-group"=>"step-1",
                "data-parsley-required"=>"true",
                "ref"=>"productName",
                "v-model"=>"productName"
                )
            
        ));
        
        $this->add(array(
            "name"=>"description",
            "type="=>"textarea",
            "options"=>array(
                "label"=>"Product Description",
                "label_attributes"=>array(
                    "class"=>"col-md-3 col-form-label text-md-right"
                )
            ),
            "attributes"=>array(
                "class"=>"form-control",
                "id"=>"description",
                "rows"=>10,
                "data-parsley-group"=>"step-1",
                "data-parsley-required"=>"true",
                // "required"=>"required",
                "ref"=>"productDescription",
                // "v-model"=>""
            )
        ));
        
        $this->add(array(
            "name"=>"tag",
            "type="=>"text",
            "options"=>array(
                "label"=>"Header Tag",
                "label_attributes"=>array(
                    "class"=>"col-md-3 col-form-label text-md-right"
                )
            ),
            "attributes"=>array(
                "class"=>"form-control",
                "id"=>"description",
                "data-parsley-group"=>"step-1",
                "v-model"=>"tag",
                "ref"=>"productTag",
//                 "required"=>"required",
            )
        ));
        
        $this->add(array(
            "name"=>"metaTitle",
            "type="=>"text",
            "options"=>array(
                "label"=>"Meta Title",
                "label_attributes"=>array(
                    "class"=>"col-md-3 col-form-label text-md-right"
                )
            ),
            "attributes"=>array(
                "class"=>"form-control",
                "id"=>"metaTitle",
                "data-parsley-group"=>"step-1",
                "ref"=>"productMetaTitle",
                "v-model"=>"metaTitle"
                //                 "required"=>"required",
            )
        ));
        
        $this->add(array(
            "name"=>"metaDescription",
            "type="=>"textarea",
            "options"=>array(
                "label"=>"Meta Description",
                "label_attributes"=>array(
                    "class"=>"col-md-3 col-form-label text-md-right"
                )
            ),
            "attributes"=>array(
                "class"=>"form-control",
                "id"=>"metaDescription",
                "rows"=>10,
                "ref"=>"metaDescription",
                "data-parsley-group"=>"step-1",
                "v-model"=>"metaDescription"
                //                 "required"=>"required",
            )
        ));
        
        $this->add(array(
            "name"=>"metaKeyword",
            "type="=>"text",
            "options"=>array(
                "label"=>"Meta Keywords",
                "label_attributes"=>array(
                    "class"=>"col-md-3 col-form-label text-md-right"
                )
            ),
            "attributes"=>array(
                "class"=>"form-control",
                "id"=>"metaKeyword",
                "data-parsley-group"=>"step-1",
                "ref"=>"metaKeyword",
                "v-model"=>"metaKeyword"
                //                 "required"=>"required",
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

