<?php
namespace Wallet\Form\Fieldset;

use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Wallet\Entity\Refferal;

/**
 *
 * @author otaba
 *        
 */
class WalletReferalFieldset extends Fieldset implements InputFilterProviderInterface
{
    
    private $entityManager;
    

    public function init(){
        $hydrator = new DoctrineObject($this->entityManager);
        $this->setObject(new Refferal())->setHydrator($hydrator);
        
        $this->add(array(
            "name"=>"referalEmail",
            "type"=>"email",
            "options"=>array(
                "label"=>"Refered Email",
                "label_attributes"=>array(
                    "class"=>"col-sm-4 form-control-label"
                )
            ),
            "attributes"=>array(
                "class"=>"form-control",
                "id"=>"referalEmail",
                "placeholder"=>"abc@yahoo.com",
                "required"=>"required",
            )
        ));
        
        $this->add(array(
            "name"=>"referalPhone",
            "type"=>"text",
            "options"=>array(
                "label"=>"Refered Phone",
                "label_attributes"=>array(
                    "class"=>"col-sm-4 form-control-label",
                ),
            ),
            "attributes"=>array(
                "class"=>"form-control",
                "id"=>"referalPhone",
                'placeholder'=>"08034343434"
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
     * @param field_type $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

}

