<?php
namespace Support\Form\Fieldset;

use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Support\Entity\Support;

/**
 *
 * @author otaba
 *        
 */
class SupportFieldset extends Fieldset implements InputFilterProviderInterface
{

    private $entityManager;

    public function init()
    {
        $hydrator = new DoctrineObject($this->entityManager);
        $this->setObject(new Support())->setHydrator($hydrator);
        
        $this->add(array(
            "name" => "supportTitle",
            "type" => "text",
            "options" => array(
                "label" => "Title",
                "label_attributes" => array(
                    "class" => "col-sm-4 form-control-label"
                )
            ),
            "attributes" => array(
                "class" => "form-control",
                "placeholder" => "Title",
                "id" => "supportTitle",
                "required"=>"required",
            )
        ));
        
        // $this->add(array(
        // 'type' => 'Laminas\Form\Element\Collection',
        // 'name' => 'conversation',
        // 'options' => array(
        // // 'label' => 'Please choose categories for this product',
        // 'count' => 1,
        // // 'should_create_template' => true,
        // 'allow_add' => true,
        // 'target_element' => array(
        // 'type' => 'Support\Form\Fieldset\SupportMessageFieldset'
        // )
        // )
        // ));
        
        // $this->add(array(
        // "name"=>"conversation",
        // "type"=>"Support\Form\Fieldset\SupportMessageFieldset"
        // ));
        
        $this->add(array(
            "name" => "messageText",
            "type" => "textarea",
            "options" => array(
                "label" => "Message",
                "label_attributes" => array(
                    "class" => ""
                )
            ),
            "attributes" => array(
                "class" => "form-control",
                "placeholder" => "Whats on your mind",
                "rows" => "4",
                "cols" => "50",
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
    {
        return array();
    }

    public function setEntityManager($em)
    {
        $this->entityManager = $em;
        return $this;
    }
}

