<?php
namespace Shop\Form\Fieldset;

use Laminas\InputFilter\InputFilter;
use DoctrineModule\Validator\NoObjectExists;

/**
 *
 * @author otaba
 *        
 */
class ProductFieldsetInputFilter extends InputFilter
{

    private $entityManager;

    /**
     */
    public function __construct()
    {
        // 'productName' => string '0000000' (length=7)
        // 'description' => string '000000000' (length=9)
        // 'metaTitle' => string '' (length=0)
        // 'metaDescription' => string '' (length=0)
        // 'metaKeyword' => string '' (length=0)
        // 'category' => string '100' (length=3)
        // 'garmentTypes' => string '26' (length=2)
        // 'availableSizes' => string '1100' (length=4)
        // 'sku' => string '00000' (length=5)
        // 'quantity' => string '1' (length=1)
        // 'price' => string '78000000' (length=8)
        // 'stockStatus' => string '10' (length=2)
        // 'isShipping' => string '1' (length=1)
        // 'isDiscount' => string '1' (length=1)
        // 'points' => string '0' (length=1)
        // 'pointMinQuantity' => string '0' (length=1)
        // 'tax' => string '10' (length=2)
        // 'dateAvailable' => string '2020-09-04' (length=10)
        // 'weight' => string '0' (length=1)
        // 'length' => string '0' (length=1)
        // 'width' => string '0' (length=1)
        // 'height' => string '0' (length=1)
        // 'subtract' => string '1' (length=1)
        // 'minimum' => string '1' (length=1)
        $this->filter();
    }

    public function filter()
    {
        $this->add(array(
            'name' => 'productName',
            'required' => true,
            "allow_empty" => false,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'First name is required'
                        )
                    )
                )
            )
        ));
        
        $this->add(array(
            'name' => 'description',
            'required' => true,
            "allow_empty" => false,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Product Description cannot be empty'
                        )
                    )
                )
            )
        ));
        
        $this->add(array(
            'name' => 'metaTitle',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Meta Title cannot Be empty and is required'
                        )
                    )
                )
            )
        ));
        
        $this->add(array(
            'name' => 'metaDescription',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            )
        
        ));
        
        $this->add(array(
            'name' => 'metaKeyword',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            )
        
        ));
        
        $this->add(array(
            'name' => 'category',
            'required' => true,
            "allow_empty" => false,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Category is required'
                        )
                    )
                )
            )
        ));
        
        $this->add(array(
            'name' => 'garmentType',
            'required' => true,
            "allow_empty" => false,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Garment Type is required'
                        )
                    )
                )
            )
        ));
        
        // $this->add(array(
        // 'name' => 'availableSizes',
        // 'required' => true,
        // "allow_empty"=>false,
        // 'filters' => array(
        // array(
        // 'name' => 'StripTags'
        // ),
        // array(
        // 'name' => 'StringTrim'
        // )
        // ),
        // 'validators' => array(
        // array(
        // 'name' => 'NotEmpty',
        // 'options' => array(
        // 'messages' => array(
        // 'isEmpty' => 'First name is required'
        // )
        // )
        // )
        // )
        // ));
        
        $this->add(array(
            'name' => 'sku',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'SKU is required'
                        )
                    )
                ),
//                 array(
                    
//                     'name' => '\DoctrineModule\Validator\NoObjectExists',
//                     'options' => array(
//                         'object_repository' => $this->entityManager,
// //                         'fields' => ["sku"],
//                         'messages' => array(
//                             NoObjectExists::ERROR_OBJECT_FOUND => "sku already exists in database."
//                         )
//                     )
                
//                 )
            )
        ));
        
        $this->add(array(
            'name' => 'price',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Price is required'
                        )
                    )
                )
            )
        ));
        
        $this->add(array(
            'name' => 'stockStatus',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'First name is required'
                        )
                    )
                )
            )
        ));
        
        $this->add(array(
            'name' => 'points',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'First name is required'
                        )
                    )
                )
            )
        ));
        
        $this->add(array(
            'name' => 'pointMinQuantity',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            )
        
        ));
        
        $this->add(array(
            'name' => 'tax',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Tax is required'
                        )
                    )
                )
            )
        ));
        
        $this->add(array(
            'name' => 'weight',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            )
        
        ));
        
        $this->add(array(
            'name' => 'length',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            )
        
        ));
        
        $this->add(array(
            'name' => 'height',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            )
        
        ));
        
        $this->add(array(
            'name' => 'width',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            )
        
        ));
        
        $this->add(array(
            'name' => 'minimum',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            )
        
        ));
    }

    public function setEntityManager($em)
    {
        $this->entityManager = $em;
        return $this;
    }
}

