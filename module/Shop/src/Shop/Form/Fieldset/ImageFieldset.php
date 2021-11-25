<?php
namespace Shop\Form\Fieldset;

use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Shop\Entity\Image;

/**
 *
 * @author otaba
 *        
 */
class ImageFieldset extends Fieldset implements InputFilterProviderInterface
{
    private $entityManager;
    
//     public function init(){
//         $hydrator = new DoctrineObject($this->entityManager);
//         $this->setObject(new Image())->setHydrator($hydrator);
//     }

    public function init(){
        $this->add(array(
            //FIXME design upload form
            // With parsley validator and vue monitor
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
}

