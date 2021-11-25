<?php
namespace Shop\Form\Fieldset;

use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Shop\Entity\ShopHomeSplashRow;

/**
 *
 * @author otaba
 *        
 */
class ShopHomeSplashFieldset extends Fieldset implements InputFilterProviderInterface
{

    private $labelClassAttributes;
    
    private $classAttribute;
    
    private $entityManager;

    public function init()
    {
        
        $this->labelClassAttributes = "col-md-3 col-form-label text-md-right";
        $this->classAttribute = "form-control";
        
        $hydrator = new DoctrineObject($this->entityManager);
        $this->setObject(new ShopHomeSplashRow())->setHydrator($hydrator);
        
        
        $this->add(array(
            "name"=>"imageTop",
            "title"=>"file",
            "options"=>array(
                "label"=>"Image Top",
                "label_attributes"=>array(
                    "class"=>$this->labelClassAttributes
                )
            ),
            "attributes"=>array(
                "class"=>$this->classAttribute,
                "id"=>"imageTop",
                "required"=>"required",
            )
        ));
        
        $this->add(array(
            "name"=>"h2HeaderTop",
            "title"=>"text",
            "options"=>array(
                "label"=>"H2 Header Top",
                "label_attributes"=>array(
                    "class"=>$this->labelClassAttributes
                )
            ),
            "attributes"=>array(
                "class"=>$this->classAttribute,
                "id"=>"h2HeaderTop",
                "required"=>"required",
            )
        ));
        
        $this->add(array(
            "name"=>"paragraphTop",
            "title"=>"text",
            "options"=>array(
                "label"=>"Top Paragraph",
                "label_attributes"=>array(
                    "class"=>$this->labelClassAttributes
                )
            ),
            "attributes"=>array(
                "class"=>$this->classAttribute,
                "id"=>"paragraphTop",
                "required"=>"required",
            )
        ));
        
        $this->add(array(
            "name"=>"isButtonTop",
            "title"=>"checkbox",
            "options"=>array(
                "label"=>"Has Button Top",
                "label_attributes"=>array(
                    "class"=>$this->labelClassAttributes
                )
            ),
            "attributes"=>array(
                "class"=>$this->classAttribute,
                "id"=>"isButtonTop",
                "required"=>"required",
            )
        ));
        
        $this->add(array(
            "name"=>"buttonUrlTop",
            "title"=>"text",
            "options"=>array(
                "label"=>"Top Button Url",
                "label_attributes"=>array(
                    "class"=>$this->labelClassAttributes
                )
            ),
            "attributes"=>array(
                "class"=>$this->classAttribute,
                "id"=>"buttonUrlTop",
                "required"=>"required",
            )
        ));
        
        
        $this->add(array(
            "name"=>"imageBottom",
            "title"=>"file",
            "options"=>array(
                "label"=>"Image Bottom",
                "label_attributes"=>array(
                    "class"=>$this->labelClassAttributes
                )
            ),
            "attributes"=>array(
                "class"=>$this->classAttribute,
                "id"=>"imageTop",
                "required"=>"required",
            )
        ));
        
        
        
        
        
        
        $this->add(array(
            "name"=>"h2HeaderBottom",
            "title"=>"text",
            "options"=>array(
                "label"=>"H2 Header Bottom",
                "label_attributes"=>array(
                    "class"=>$this->labelClassAttributes
                )
            ),
            "attributes"=>array(
                "class"=>$this->classAttribute,
                "id"=>"h2HeaderBottom",
                "required"=>"required",
            )
        ));
        
        $this->add(array(
            "name"=>"paragraphBottom",
            "title"=>"text",
            "options"=>array(
                "label"=>"Bottom Paragraph",
                "label_attributes"=>array(
                    "class"=>$this->labelClassAttributes
                )
            ),
            "attributes"=>array(
                "class"=>$this->classAttribute,
                "id"=>"paragraphTop",
                "required"=>"required",
            )
        ));
        
        $this->add(array(
            "name"=>"isButtonBottom",
            "title"=>"checkbox",
            "options"=>array(
                "label"=>"Has Button Bottom",
                "label_attributes"=>array(
                    "class"=>$this->labelClassAttributes
                )
            ),
            "attributes"=>array(
                "class"=>$this->classAttribute,
                "id"=>"isButtonBottom",
                "required"=>"required",
            )
        ));
        
        $this->add(array(
            "name"=>"buttonUrlBottom",
            "title"=>"text",
            "options"=>array(
                "label"=>"Bottom Button Url",
                "label_attributes"=>array(
                    "class"=>$this->labelClassAttributes
                )
            ),
            "attributes"=>array(
                "class"=>$this->classAttribute,
                "id"=>"buttonUrlBottom",
                "required"=>"required",
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
    {}
    /**
     * @param field_type $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

}

