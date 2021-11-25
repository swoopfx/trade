<?php
namespace Wallet\Form\Fieldset;

use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Wallet\Entity\WalletTransaction;
use Laminas\Validator\StringLength;

class WalletTransactionFieldset extends Fieldset implements InputFilterProviderInterface
{
    private $entityManager;
    

    public function init(){
        $hydrator = new DoctrineObject($this->entityManager);
        $this->setHydrator($hydrator)->setObject(new WalletTransaction());
        
        $this->add(array(
            "type"=>"text",
            "name"=>"amount",
            "options"=>array(
                'label' => 'Transaction Amount',
                'label_attributes' => array(
                    'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                )
            ),
            "attributes"=>array(
                "id"=>"amount",
                'class' => 'form-control col-md-3 col-sm-3 col-xs-12',
//                 "placeholder"=>"0.00",
            ),
        ));
        
        $this->add(array(
            "name" => "passcode",
            "type" => "password",
            "options" => array(
                "label" => "Wallet Passcode",
                'label_attributes' => array(
                    'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                )
            ),
            "attributes"=>array(
                "id"=>"passcode",
                "class"=>"form-control col-md-12 col-sm-12 col-xs-12",
                "required"=>"required",
                
            )
        ));
    }

    public function getInputFilterSpecification()
    {

        return array(
            "passcode" => array(
                "required" => true,
                "allow_empty" => false,
                "filters" => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                "validators" => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 6,
                            'max' => 50,
                            "messages" => array(
                                StringLength::TOO_SHORT => "The passcode must be more than 6 characters",
                                StringLength::TOO_LONG => "This passcode is too long to memorize"
                            )
                        )
                    )
                )
            ),
        );
    }
    /**
     * @param mixed $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    
    
}

