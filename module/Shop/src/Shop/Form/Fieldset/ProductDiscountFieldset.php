<?php
namespace Shop\Form\Fieldset;

use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Shop\Entity\ProductDiscount;

/**
 *
 * @author otaba
 *        
 */
class ProductDiscountFieldset extends Fieldset implements InputFilterProviderInterface
{

    private $labelClassAttributes;

    private $classAttribute;

    private $entityManager;

    public function init()
    {
        $this->labelClassAttributes = "col-md-3 col-form-label text-md-right";
        $this->classAttribute = "form-control";
        
        $hydrator = new DoctrineObject($this->entityManager);
        $this->setObject(new ProductDiscount())->setHydrator($hydrator);
        
        $this->add(array(
            "name" => "quantity",
            'type' => "number",
            "options" => array(
                "label" => "Discount Quantity",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                )
            ),
            "attributes" => array(
                "class" => $this->classAttribute,
                "id" => "quantity",
                "data-parsley-type" => "number",
                "data-parsley-group" => "step-2",
                "data-parsley-required" => "true",
                
                // "v-model"=>"discount_quantit",
                "ref"=>"discount_quantity",
//                 "required" => "required",
                "value" => 1
            )
        ));
        
        $this->add(array(
            "name" => "discountPrice",
            'type' => "text",
            "options" => array(
                "label" => "Discount Price",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                )
            ),
            "attributes" => array(
                "class" => $this->classAttribute,
                "id" => "price",
//                 "required" => "required",
                "data-parsley-type" => "number",
                "data-parsley-group" => "step-2",
                "data-parsley-required" => "true",
                "ref" => "discountPrice",
                "v-on:change"=>"validateDiscountPrice()",
                // "v-model"=>"discountPrice",
                "value" => "0"
            )
        ));
        
        $this->add(array(
            "name" => "dateStart",
            'type' => "date",
            "options" => array(
                "label" => "Date Start",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                )
            ),
            "attributes" => array(
                "class" => $this->classAttribute,
                "id" => "dateStart",
                "min"=>date("Y-m-d"),
                "value" => date("Y-m-d"),
                // "data-parsley-type" => "number",
//                 "data-date-minDate" => date(),
                "data-parsley-group" => "step-2",
                "data-parsley-required" => "true",
                "ref" => "discountDateStart",
                // "v-model"=>"discountDateStart",
//                 "value" => 0
            )
        ));
        
        
        $this->add(array(
            "name" => "dateEnd",
            'type' => "date",
            "options" => array(
                "label" => "Date End",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                )
            ),
            "attributes" => array(
                "class" => $this->classAttribute,
                "id" => "dateEnd",
                "min"=>date("Y-m-d"),
//                 "data-parsley-type" => "",
//                 "data-parsley-mindate" => date(),
                "data-parsley-group" => "step-2",
                "data-parsley-required" => "true",
                "ref" => "discountDateEnd",
                // "v-model"=>"discountDateEnd"
//                 "value" => 0
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

