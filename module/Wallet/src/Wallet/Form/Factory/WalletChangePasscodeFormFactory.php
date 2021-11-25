<?php
namespace Wallet\Form\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Wallet\Form\WalletChangePasscodeForm;

class WalletChangePasscodeFormFactory implements FactoryInterface
{

    public function __construct()
    {

        // TODO - Insert your code here
    }

    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        $form = new WalletChangePasscodeForm();
        return $form;
    }
}

