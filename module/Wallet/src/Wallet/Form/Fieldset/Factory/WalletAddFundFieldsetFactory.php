<?php
namespace Wallet\Form\Fieldset\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Wallet\Form\Fieldset\WalletAddFundFieldset;

class WalletAddFundFieldsetFactory implements FactoryInterface
{

    public function __construct()
    {

        // TODO - Insert your code here
    }

    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        $fieldset = new WalletAddFundFieldset();
        return $fieldset;
    }
}

