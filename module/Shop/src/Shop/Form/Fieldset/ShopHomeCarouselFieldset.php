<?php
namespace Shop\Form\Fieldset;

use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Shop\Entity\ShopHomeMainCarousel;
use Doctrine\ORM\EntityManager;

/**
 *
 * @author otaba
 *        
 */
class ShopHomeCarouselFieldset extends Fieldset implements InputFilterProviderInterface
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

    public function init()
    {
        $this->labelClassAttributes = "col-md-3 col-form-label text-md-right";
        $this->classAttribute = "form-control";
        
        $hydrator = new DoctrineObject($this->entityManager);
        $this->setObject(new ShopHomeMainCarousel())->setHydrator($hydrator);
        
        $this->add(array(
            "name" => "subheading",
            "type" => "text",
            "options" => array(
                "label" => "Sub Header",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                )
            ),
            "attributes" => array(
                "class" => $this->classAttribute,
                "id" => "subheading",
                "data-parsley-required" => "true",
                "required" => "required"
            )
        ));
        
        $this->add(array(
            "name" => "h1Text",
            "type" => "text",
            "options" => array(
                "label" => "H1 Text",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                )
            ),
            "attributes" => array(
                "class" => $this->classAttribute,
                "id" => "h1Text",
                "data-parsley-required" => "true",
                "required" => "required"
            )
        ));
        
        $this->add(array(
            "name" => "h1SpanText",
            "type" => "text",
            "options" => array(
                "label" => "H1 Text",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                )
            ),
            "attributes" => array(
                "class" => $this->classAttribute,
                "id" => "h1SpanText",
                "data-parsley-required" => "true",
                "required" => "required"
            )
        ));
        
        $this->add(array(
            "name" => "paragraphText",
            "type" => "textarea",
            "options" => array(
                "label" => "Paragraph Text",
                "label_attributes" => array(
                    "class" => $this->labelClassAttributes
                )
            ),
            "attributes" => array(
                "class" => $this->classAttribute,
                "id" => "paragraphText",
                "data-parsley-required" => "true",
                "required" => "required"
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
     *
     * @param \Doctrine\ORM\EntityManager $entityManager            
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }
}

