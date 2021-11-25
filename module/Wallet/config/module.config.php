<?php
namespace Wallet;

use Wallet\Controller\Factory\WalletasyncControllerFactory;

return array(
    "controllers" => array(
        "factories" => array(
            "Wallet\Controller\Wallet" => "Wallet\Controller\Factory\WalletControllerFactory",
            "Wallet\Controller\Referal"=>"Wallet\Controller\Factory\ReferalControllerFactory",
            "Wallet\Controller\Walletasync"=>WalletasyncControllerFactory::class,
        )
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'Wallet' => __DIR__ . '/../view'
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
        "template_map" => array(
            'wallet_transactions_list_snippet' => __DIR__ . '/../view/wallet/partials/wallet_transaction_list_snippet.phtml',
            "wallet_transaction_fieldset_snippet" => __DIR__ . '/../view/wallet/partials/wallet_transaction_fieldset_snippet.phtml',
            "wallet_passcode_fieldset_snippet" => __DIR__ . '/../view/wallet/partials/wallet_passcode_fieldset_snippet.phtml',
            "wallet_add_funds_fieldset_snippet" => __DIR__ . '/../view/wallet/partials/wallet_add_fund_fieldset_snippet.phtml',
            "wallet_change_passcode_fieldset_snippet" => __DIR__ . '/../view/wallet/partials/wallet_change_passcode_fieldset_snippet.phtml',
            // Fieldset
            "wallet_referal_fieldset_snippet" => __DIR__ . '/../view/wallet/partials/fieldset/wallet-referal-fieldset.phtml',
            
           
            
            "wallet_transaction_modal_form_snippet" => __DIR__ . '/../view/wallet/partials/modal/wallet_transaction_modal_form_snippet.phtml',
            "wallet_passcode_modal_form_snippet" => __DIR__ . '/../view/wallet/partials/modal/wallet_passcode_modal_form_snippet.phtml',
            "wallet_add_fund_modal_form_snippet" => __DIR__ . '/../view/wallet/partials/modal/wallet_add_fund_modal_form_snippet.phtml',
            "wallet_change_passcode_modal_form_snippet" => __DIR__ . '/../view/wallet/partials/modal/wallet_change_passcode_modal_form_snippet.phtml',
            
            // Form 
            "wallet-referal-form" => __DIR__ . '/../view/wallet/partials/form/wallet-referal-form-snippet.phtml'
            
            
        )
    ),
    
    'view_helpers' => array(
        "invokables"=>array(
            "walletAvailableBalance"=>"Wallet\View\Helper\WalletAvailableBalanceHelper",
            "creditAvailaibleBalance"=>"Wallet\View\Helper\WalletAvailableCreditHelper",
            "walletAggregateBookBalance"=>"Wallet\View\Helper\WalletAggregatedBookBalance",
            "walletCreditBonus"=>"Wallet\View\Helper\WalletAvailableCreditBonusHelper",
            "walletReferalBonus"=>"Wallet\View\Helper\WalletReferalBonusHelper",
            
            
        )
    ),

    'service_manager' => array(
        'factories' => array(
            "Wallet\Service\WalletService" => "Wallet\Service\Factory\WalletServiceFactory",
            "Wallet\Service\CreditService" =>"Wallet\Service\Factory\CreditServiceFactory",
            "Wallet\Service\ReferalService" =>"Wallet\Service\Factory\ReferalServiceFactory",

            // Pagniator
            "Wallet\Paginator\WalletAdapter"=>"Wallet\Paginator\Factory\WalletAdapterFactory"
        )
    ),

    'router' => array(
        'routes' => array(

            'wallet' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/wallet',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Wallet\Controller',
                        'controller' => 'Wallet',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:action[/:id]]',
                            'constraints' => array(

                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array()
                        )
                    )
                )
            ),
            
            'walletasync' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/walletasync',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Wallet\Controller',
                        'controller' => 'Walletasync',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:action[/:id]]',
                            'constraints' => array(
                                
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array()
                        )
                    )
                )
            ),
            
            'referal' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/referal',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Wallet\Controller',
                        'controller' => 'Referal',
                        'action' => 'make'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:action[/:id]]',
                            'constraints' => array(
                                
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array()
                        )
                    )
                )
            )
        )
    ),
    "form_elements" => array(
        "factories" => array(
            "Wallet\Form\Fieldset\WalletTransactionFieldset" => "Wallet\Form\Fieldset\Factory\WalletTransactionFieldsetFactory",
            "Wallet\Form\Fieldset\WalletPasscodeFieldset" => "Wallet\Form\Fieldset\Factory\WalletPasscodeFieldsetFactory",
            "Wallet\Form\Fieldset\WalletAddFundFieldset" => "Wallet\Form\Fieldset\Factory\WalletAddFundFieldsetFactory",
            "Wallet\Form\Fieldset\WalletChangePasscodeFieldset" => "Wallet\Form\Fieldset\Factory\WalletChangePasscodeFieldsetFactory",
            "Wallet\Form\Fieldset\WalletReferalFieldset" => "Wallet\Form\Fieldset\Factory\WalletReferalFieldsetFactory",
            
            "Wallet\Form\WalletTransactionForm" => "Wallet\Form\Factory\WalletTransactionFormFactory",
            "Wallet\Form\WalletPasscodeForm" => "Wallet\Form\Factory\WalletPasscodeFormFactory",
            "Wallet\Form\WalletAddFundForm" => "Wallet\Form\Factory\WalletAddFundFormFactory",
            "Wallet\Form\WalletChangePasscodeFormFactory" => "Wallet\Form\Factory\WalletChangePasscodeFormFactory",
            "Wallet\Form\WalletReferalForm"=>"Wallet\Form\Factory\WalletReferalFormFactory"
        )
    ),

    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    )
);