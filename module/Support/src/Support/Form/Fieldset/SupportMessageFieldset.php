<?php
namespace Support\Form\Fieldset;

use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Support\Entity\SupportMessages;

/**
 *
 * @author otaba
 *        
 */
class SupportMessageFieldset extends Fieldset implements InputFilterProviderInterface
{
    
    private $entityManager;

   public function init(){
       $hydrator = new DoctrineObject($this->entityManager);
       $this->setObject(new SupportMessages())->setHydrator($hydrator);
       
       $this->add(array(
           "name"=>"messageText",
           "type"=>"textarea",
           "options"=>array(
               "label"=>"Message",
               "label_attributes"=>array(
                   "class"=>""
               )
           ),
           "attributes"=>array(
               "class"=>"form-control",
               "placeholder"=>"Whats on your mind",
               "rows"=>"4",
               "cols"=>"50",
//                "required"=>"required",
           ),
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

