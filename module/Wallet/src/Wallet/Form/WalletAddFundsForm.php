<?php
namespace Wallet\Form;

use Laminas\Form\Form;

class WalletAddFundsForm extends Form
{

    public function init(){
        $this->setAttributes(array(
            "method"=>"POST",
            "class"=>"form-horizontal form-label-left"
        ));
        
        $this->add(array(
            "name"=>"walletAddFundFieldset",
            "type"=>"Wallet\Form\Fieldset\WalletAddFundFieldset",
            "options"=>array(
                "use_as_base_fieldset"=>true
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Submit',
                'class' => 'btn btn-xs btn-primary btn-block'
            )
        ));
    }
}

