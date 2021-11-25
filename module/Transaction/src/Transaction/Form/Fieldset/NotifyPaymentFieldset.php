<?php
namespace Transaction\Form\Fieldset;

use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Transaction\Entity\NotifyPayment;

class NotifyPaymentFieldset extends Fieldset implements InputFilterProviderInterface
{
    
    /**
     * 
     * @var EntityManager
     */
    private $entityManager;
    
   

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    public function init(){
        $hydrator = new DoctrineObject($this->entityManager);
        $this->setHydrator($hydrator)->setObject(new NotifyPayment());
       
        $this->add(array(
            "name"=>"nameOfPayee",
            "type"=>"text",
            "options"=>array(
                "label"=>"Name Of Payee",
                "label_attributes"=>array(
                    "class"=>"col-sm-4 form-control-label"
                )
            ),
            "attributes"=>array(
                "class"=>"form-control",
                "id"=>"nameOfPayee",
                "placeholder"=>"Kunle Jolariya",
                "required"=>"required",
            ),
        ));
        
        $this->add(array(
            "name"=>"datePaid",
            "type"=>"date",
            "options"=>array(
                "label"=>"Payment Date",
                "label_attributes"=>array(
                    "class"=>"col-sm-4 form-control-label"
                )
            ),
            "attributes"=>array(
                "class"=>"form-control",
                "id"=>"datePaid",
                //                 "placeholder"=>"Ibrahim",
                "required"=>"required",
            ),
        ));
        
        $this->add(array(
            "name"=>"amountPaid",
            "type"=>"text",
            "options"=>array(
                "label"=>"Amount Paid",
                "label_attributes"=>array(
                    "class"=>"col-sm-4 form-control-label"
                )
            ),
            "attributes"=>array(
                "class"=>"form-control",
                "id"=>"amountPaid",
                "placeholder"=>"20000",
                "required"=>"required",
            ),
        ));
        
        $this->add(array(
            "name"=>"paymentDetails",
            "type"=>"textarea",
            "options"=>array(
                "label"=>"Payment Details",
                "label_attributes"=>array(
                    "class"=>"col-sm-4 form-control-label"
                )
            ),
            "attributes"=>array(
                "class"=>"form-control",
                "id"=>"paymentDetails",
//                 "placeholder"=>"20000",
//                 "required"=>"required",
            ),
        ));
        
       
    }

    public function getInputFilterSpecification()
    {
        return array();
    }
}

