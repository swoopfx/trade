<?php
namespace Wallet\Form\Fieldset;

use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use Laminas\Validator\StringLength;
use Laminas\Validator\Identical;

class WalletChangePasscodeFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function init()
    {
        $this->add(array(
            "name" => "oldpasscode",
            "type" => "password",
            "options" => array(
                "label" => "Wallet Present Passcode",
                'label_attributes' => array(
                    'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                )
            ),
            "attributes" => array(
                "id" => "oldpasscode",
                "class" => "form-control col-md-12 col-sm-12 col-xs-12",
                "required" => "required"
            )
        ));

        $this->add(array(
            "name" => "passcode",
            "type" => "password",
            "options" => array(
                "label" => "New Passcode",
                'label_attributes' => array(
                    'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                )
            ),
            "attributes" => array(
                "id" => "passcode",
                "class" => "form-control col-md-12 col-sm-12 col-xs-12",
                "required" => "required"
            )
        ));

        $this->add(array(
            "name" => "confirmpasscode",
            "type" => "password",
            "options" => array(
                "label" => "Confirm Wallet Passcode",
                'label_attributes' => array(
                    'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                )
            ),
            "attributes" => array(
                "id" => "confirmpasscode",
                "class" => "form-control col-md-12 col-sm-12 col-xs-12",
                "required" => "required"
            )
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            "oldpasscode" => array(
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

            "confirmpasscode" => array(
                "required" => true,
                "allow_empty" => false,
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
                    ),
                    array(
                        'name' => 'Identical',
                        'options' => array(
                            'token' => 'passcode',
                            "messages" => array(
                                Identical::NOT_SAME => "The passwords are not identical"
                            )
                        )
                    )
                )
            )
        );
    }
}

