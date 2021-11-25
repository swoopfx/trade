<?php
namespace Shop\Form\Fieldset;

use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Shop\Entity\Product;
use Shop\Service\ProductService;
use DoctrineModule\Validator\NoObjectExists;

/**
 *
 * @author otaba
 *        
 */
class ProductFieldset extends Fieldset implements InputFilterProviderInterface
{

    private $labelClassAttributes;

    private $classAttribute;

    private $entityManager;

    public function init()
    {
        $this->labelClassAttributes = "col-md-3 col-form-label text-md-right";
        $this->classAttribute = "form-control";
        
        $hydrator = new DoctrineObject($this->entityManager);
        $this->setObject(new Product())->setHydrator($hydrator);
        
        $this->add(array(
            "name" => "productDescription",
            "type" => "Shop\Form\Fieldset\ProductDescriptionFieldset"
        ));
        
        $this->add(array(
            "name" => "category",
            "type" => "DoctrineModule\Form\Element\ObjectSelect",
            "options" => array(
                "label" => "Product Category",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                ),
                "object_manager" => $this->entityManager,
                "target_class" => "Shop\Entity\Category",
                "property" => "category"
            ),
            "attributes" => array(
                "class" => "form-control",
                "id" => "category",
                "required" => "required",
                "data-parsley-group"=>"step-2",
                "data-parsley-required" => "true",
                "ref"=>"category",
                "v-on:change"=>"selectGarmentType()",
                "v-model" => "category"
            )
        ));
        
        $this->add(array(
            "name" => "garmentType",
            "type" => "DoctrineModule\Form\Element\ObjectSelect",
            "options" => array(
                "label" => "Garment Type",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                ),
                "object_manager" => $this->entityManager,
                "target_class" => "Settings\Entity\GarmentType",
                "property" => "garmentType"
            ),
            "attributes" => array(
                "class" => "form-control",
                "id" => "garmentType",
                "required" => "required",
                "data-parsley-group"=>"step-2",
                "data-parsley-required" => "true",
                "ref"=>"garmentTypes",
                ":disabled"=>"garmentTypeDisabled",
                "data-parsley-required" => "true",
                "v-model" => "garmentType"
            )
        ));


        $this->add(array(
            "name" => "garmentSex",
            "type" => "DoctrineModule\Form\Element\ObjectSelect",
            "options" => array(
                "label" => "Garment Sex",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                ),
                "object_manager" => $this->entityManager,
                "target_class" => "Settings\Entity\Sex",
                "property" => "sex"
            ),
            "attributes" => array(
                "class" => "form-control",
                "id" => "garmentSex",
                // "required" => "required",
                "data-parsley-group"=>"step-2",
                // "data-parsley-required" => "true",
                "ref"=>"garmentSex",
                ":disabled"=>"garmentTypeDisabled",
                "data-parsley-required" => "true",
                "v-model" => "garmentSex"
            )
        ));
        
        // $this->add(array(
        //     'type' => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
        //     'name' => 'availableSizes',
        //     'options' => array(
        //         "label" => "Availaible Sizes",
        //         'label_attributes' => array(
        //             'class' => $this->labelClassAttributes . ' checkbox inline'
        //         ),
        //         'object_manager' => $this->entityManager,
        //         'target_class' => 'Settings\Entity\Size',
        //         'property' => 'size'
                
        //         // 'is_method' => true,
        //         // 'find_method' => array(
        //         // 'name' => 'findAll',
        //         // ),
        //     ),
        //     "attributes" => array(
        //         "class" => "form-check-input",
        //         "required" => "required",
        //         "ref"=>"availableSizes",
        //         "data-parsley-group" => "step-2",
        //         "data-parsley-required" => "true",
        //         'data-parsley-mincheck' => "1",
        //         "v-model" => "availableSizes"
        //     )
        // ));
        
        $this->add(array(
            "name" => "productAttributes",
            "type" => "Laminas\Form\Element\Collection",
            'options' => array(
                'label' => 'Attributes',
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                ),
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => array(
                    'type' => 'Shop\Form\Fieldset\ProductAttributesFieldset'
                )
            ),
            "attributes" => array(
                "class" => $this->classAttribute,
                "v-model" => "productAttributes",
                "ref"=>"productAttributes"
            )
        ));
        
        $this->add(array(
            "name" => "productFeatures",
            "type" => "Laminas\Form\Element\Collection",
            "options" => array(
                "label" => "Features",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                
                ),
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => array(
                    'type' => 'Shop\Form\Fieldset\ProductFeatureFieldset'
                )
            ),
            "attributes" => array(
                "class" => $this->classAttribute,
                "data-parsley-group" => "step-3",
                "v-model" => "productFeatures",
                "ref"=>"productFeatures"
                // "id"=>"productFeatures"
            )
        ));
        
        $this->add(array(
            "name" => "sku",
            "type" => "text",
            "options" => array(
                "label" => "Unique identifier",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                )
            ),
            "attributes" => array(
                "class" => $this->classAttribute,
                "id" => "sku",
                "placeholder" => "WA123QER",
                "data-parsley-type"=>"alphanum",
                "data-parsley-group" => "step-1",
                "data-parsley-minlength" => '5',
                "data-parsley-required" => "true",
                "required" => "required",
                "ref"=>"sku",
                // "@click"=>"checkSkuValidation()",
                "v-on:change"=>"checkSkuValidation()"
                // "v-model" => "sku"
            )
        ));
        
//         $this->add(array(
//             "name" => "quantity",
//             "type" => "number",
//             "options" => array(
//                 "label" => "Quantity Availaible",
//                 "label_attributes" => array(
//                     "class" => $this->labelClassAttributes
//                 )
//             ),
//             "attributes" => array(
//                 "class" => $this->classAttribute,
//                 "id" => "quantity",
//                 "min" => 1,
// //                 "data-parsley-trigger" => ">keyup",
//                 "data-parsley-type" => "digits",
//                 "data-parsley-group" => "step-2",
//                 "min"=>0,
//                 "data-parsley-required" => "true",
//                 "required" => "required",
//                 "v-model" => "quantity",
//                 "ref"=>"quantity"
//                 // ":value" => "qua"
//             )
//         ));
        
        $this->add(array(
            "name" => "price",
            "type" => "number",
            "options" => array(
                "label" => "Product Price",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                )
            ),
            "attributes" => array(
                "class" => $this->classAttribute,
                "id" => "price",
//                 "data-parsley-trigger" => ">keyup",
                "data-parsley-type" => "number",
                "data-parsley-group" => "step-2",
                "data-parsley-required" => "true",
                "required" => "required",
                "min"=>0,
                "ref"=>"price",
                "v-model" => "price",
                // "v-on:change"=>"checkSkuValidation()"
                // "value" => "0"
            )
        ));
        
        $this->add(array(
            "name" => "stockStatus",
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            "options" => array(
                "label" => "Stock Status",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                ),
                "object_manager" => $this->entityManager,
                "target_class" => "Shop\Entity\StockStatus",
                "property" => "status"
            ),
            "attributes" => array(
                "class" => $this->classAttribute . " selectpicker",
                "id" => "stockStatus",
                "required" => "required",
                "data-parsley-group" => "step-2",
                "data-parsley-required" => "true",
                "ref"=>"stockStatus",
//                 'data-style' => "btn-success",
//                 "v-model" => "stockStatus",
//                 "value" => ProductService::PRODUCT_STOCK_STATUS_IN_STOCK
            
            )
        ));
        
        $this->add(array(
            "name" => "isShipping",
            "type" => "checkbox",
            "options" => array(
                "label" => "Require Shipping",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                )
            ),
            "attributes" => array(
                "class" => $this->classAttribute ."form-check-input",
                "id" => "isShipping",
                "data-parsley-group" => "step-2",
                "value" => 1,
                "ref"=>"isShipping",
                "@click"=>"shippingStatus()",
                "v-model"=>"isShipping"
            
            )
        ));
        
      
        
        $this->add(array(
            "name" => "isDiscount",
            "type" => "checkbox",
            "options" => array(
                "label" => "Has Discount",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                )
            ),
            "attributes" => array(
                "class" => $this->classAttribute ."form-check-input",
                "id" => "isDiscount",
                "data-parsley-group" => "step-2",
                "value" => "0",
                "@click"=>"disCountCheckboxStatus()",
                "v-model" => "isDiscount",
                "ref"=>"isDiscount",
            )
        ));
        
        $this->add(array(
            "name" => "discount",
            "type" => "Shop\Form\Fieldset\ProductDiscountFieldset"
        ));
        
        $this->add(array(
            "name" => "points",
            "type" => "number",
            "options" => array(
                "label" => "Product Points",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                )
            ),
            "attributes" => array(
                "class" => $this->classAttribute,
                "id" => "points",
                "data-parsley-type" => "number",
                "data-parsley-group" => "step-2",
                "min" => 0,
                "max" => 10,
                "value" => 0,
                "v-model"=>"points",
                "ref"=>"points"
            )
        ));
        
        $this->add(array(
            "name" => "pointMinQuantity",
            "type" => "number",
            "options" => array(
                "label" => "Point Minimum Quantity",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                )
            ),
            "attributes" => array(
                "class" => $this->classAttribute,
                "id" => "pointMinQuantity",
                "data-parsley-group" => "step-2",
                "value" => 0,
                "min"=>0,
                "v-model"=>"pointMinQuantity",
                "ref"=>"pointMinQuantity",
            )
        ));
        
        $this->add(array(
            'name' => 'tax',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'label' => 'Tax :',
                'label_attributes' => array(
                    'class' => $this->labelClassAttributes
                ),
                'object_manager' => $this->entityManager,
                'target_class' => 'Settings\Entity\Tax',
                'property' => 'taxName',
               
            ),
            'attributes' => array(
                "class" => $this->classAttribute,
                "id" => "tax",
                "value"=>10,
                "data-parsley-group" => "step-2",
                "required"=>"required",
                "data-parsley-required" => "true",
                
                "v-model"=>"productTax",
                "ref"=>"productTax"
                
            
            )
        ));
        
        $this->add(array(
            "name" => "dateAvailable",
            "type" => "date",
            "options" => array(
                "label" => "Date Availaible",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                
                ),
                'format' => 'Y-m-d'
            ),
            "attributes" => array(
                "class" => $this->classAttribute,
                "id" => "dateAvailable",
                "v-model.lazy" => "dateAvailable",
                "data-parsley-group" => "step-2",
                "min" => date("Y-m-d"),
                "value" => date("Y-m-d"),
                "ref"=>"dateAvailaible",
                
            
            )
        ));
        
        $this->add(array(
            "name" => "weight",
            "type" => "text",
            "options" => array(
                "label" => "Weight",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                )
            ),
            "attributes" => array(
                "class" => $this->classAttribute,
                "id" => "weight",
                "value" => "0.00",
                "v-model" => "weight",
                "ref"=>"weight",
            )
        ));
        
        $this->add(array(
            "name" => "length",
            "type" => "text",
            "options" => array(
                "label" => "Length",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                )
            ),
            "attributes" => array(
                "class" => $this->classAttribute,
                "id" => "length",
                "value" => "0.00",
                "v-model" => "length",
                "ref"=>"length"
            )
        ));
        
        $this->add(array(
            "name" => "height",
            "type" => "text",
            "options" => array(
                "label" => "Height",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                )
            ),
            "attributes" => array(
                "class" => $this->classAttribute,
                "id" => "height",
                "ref" => "height",
                "v-model" => "height"
                // "v-on:keyup"=>"changename"
            
            )
        ));
        
        $this->add(array(
            "name" => "width",
            "type" => "text",
            "options" => array(
                "label" => "Width",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                )
            ),
            "attributes" => array(
                "class" => $this->classAttribute,
                "id" => "width",
                "value" => "0.00",
                "ref"=>"width",
                "v-model"=>"width"
            
            )
        ));
        
        $this->add(array(
            "name" => "minimum",
            "type" => "number",
            "options" => array(
                "label" => "Minimum Quantity",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                )
            ),
            "attributes" => array(
                "class" => $this->classAttribute,
                "id" => "minimum",
//                 "v-model"=>"minimum",
                "ref"=>"minimum",
                "value" => 1,
                "min" => 1,
                "step" => 1
            )
        ));
        
        $this->add(array(
            "name" => "subtract",
            "type" => "checkbox",
            "options" => array(
                "label" => "Subtract Quantity",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                )
            ),
            "attributes" => array(
                "class" => "form-check-input",
                "id" => "subtract",
                "ref"=>"subtract",
                "v-model"=>"isSubtractQuantity",
                "@click"=>"subtractQuantity()",
                "value" => 1
            )
        ));
        
        // $this->add(array(
        // "name" => "minimum",
        // "type" => "number",
        // "options" => array(
        // "label" => "Minimum Qauntity",
        // "label_attriburtes" => array(
        // "class" => $this->labelClassAttributes
        // )
        // ),
        // "attributes" => array(
        // "class" => $this->classAttribute,
        // "id" => "minimum",
        // "value" => "0.00"
        // )
        // ));
        
        // $this->add(array(
        // 'name'=>'customerCategory',
        // 'type'=>'DoctrineModule\Form\Element\ObjectRadio',
        
        // 'options' => array(
        // 'label' => 'State:',
        // 'label_attributes' => array(
        // 'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
        // ),
        // 'object_manager' => $this->entityManager,
        // 'target_class' => 'Customer\Entity\CustomerCategory',
        // 'property' => 'category',
        // 'empty_option' => '--- Select State/Region ---',
        // 'is_method' => true,
        // // 'find_method' => array(
        // // 'name' => 'findSpecificZone'
        // // )
        // ),
        // 'attributes'=>array(
        // //'data-ng-click' => "isDobF()"
        // )
        // ));
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
            "sku" => array(
                "required" => true,
                "allow_empty" => false,
                'validators' => array(
                    array(
                        'name' => 'Laminas\Validator\StringLength',
                        'options' => array(
                            'min' => 5,
                            'max' => 50,
                            'messages' => array(
                                \Laminas\Validator\StringLength::TOO_SHORT => 'Your SKU is Invalid'
                            )
                        )
                    ),
                    array(
                        'name' => 'DoctrineModule\Validator\NoObjectExists',
                        'options' => array(
                            'use_context' => true,
                            'object_repository' => $this->entityManager->getRepository('Shop\Entity\Product'),
                            'object_manager' => $this->entityManager,
                            'fields' => array(
                                'sku'
                            ),
                            'messages' => array(
                                
                                NoObjectExists::ERROR_OBJECT_FOUND => 'This uniqure identifier already exist'
                            )
                        )
                    )
                )
            )
        );
    }

    public function setEntityManager($em)
    {
        $this->entityManager = $em;
        return $this;
    }
}

