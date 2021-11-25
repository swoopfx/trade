<?php
namespace Bbmin;

use Bbmin\Paginator\Factory\OrderAdminPaginatorFactory;
use Bbmin\Paginator\Factory\TrainingAdminPaginatorInterface;
use Bbmin\View\Helper\Product\BbminProductBoolenStateHelper;
use Bbmin\View\Helper\Training\BbminTrainingActivationActiveHelper;

return array(
    'controllers' => array(
        // 'invokables' => array(
        // 'Bbmin\Controller\Bbmin' => 'Bbmin\Controller\BbminController',
        // ),
        'factories' => array(
            'Bbmin\Controller\Bbmin' => 'Bbmin\Controller\Factory\BbminControllerFactory',
            'Bbmin\Controller\Shop' => 'Bbmin\Controller\Factory\ShopControllerFactoy',
            'Bbmin\Controller\Wallet' => 'Bbmin\Controller\Factory\WalletControllerFactory',
            'Bbmin\Controller\Customer' => 'Bbmin\Controller\Factory\CustomerControllerFactory',
            'Bbmin\Controller\Sales' => 'Bbmin\Controller\Factory\SalesControllerFactory',
            'Bbmin\Controller\System' => 'Bbmin\Controller\Factory\CustomerControllerFactory',
            'Bbmin\Controller\Support' => 'Bbmin\Controller\Factory\SupportControllerFactory',
            'Bbmin\Controller\Training' => 'Bbmin\Controller\Factory\TrainingControllerFactory',
            'Bbmin\Controller\Trainingjson' => 'Bbmin\Controller\Factory\TrainingjsonControllerFactory',
            'Bbmin\Controller\Productjson' => 'Bbmin\Controller\Factory\ProductjsonControllerFactory',
            'Bbmin\Controller\Market' => 'Bbmin\Controller\Factory\CustomerControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'bbmin' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/bbmin',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Bbmin\Controller',
                        'controller' => 'Bbmin',
                        'action' => 'index',
                    ),
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
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                "id" => '[a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(),
                        ),
                    ),
                ),
            ),

            'bbminshop' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/bbmin/shop',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Bbmin\Controller',
                        'controller' => 'Shop',
                        'action' => 'product',
                    ),
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
                                // 'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                "id" => '[a-zA-Z0-9_-]*',

                            ),
                            'defaults' => array(),
                        ),
                    ),
                    "paginator" => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:action[/page[/:page]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                "page" => "[0-9]+",
                            ),

                        ),
                    ),
                ),
            ),

            'bbmincustomer' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/bbmin/customer',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Bbmin\Controller',
                        'controller' => 'Customer',
                        'action' => 'all',
                    ),
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
                            'route' => '[/:action[/:id][/page[/:page]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                "id" => '[a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(),
                        ),
                    ),
                ),
            ),

            'bbminmarket' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/bbmin/market',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Bbmin\Controller',
                        'controller' => 'Market',
                        'action' => 'index',
                    ),
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
                            'route' => '[/:action[/:id][/page[/:page]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                "id" => '[a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(),
                        ),
                    ),
                ),
            ),

            'bbminsales' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/bbmin/sales',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Bbmin\Controller',
                        'controller' => 'Sales',
                        'action' => 'order',
                    ),
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
                            'route' => '[/:action[/:id][/page[/:page]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                "id" => '[a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(),
                        ),
                    ),
                ),
            ),

            'bbminsystem' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/bbmin/system',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Bbmin\Controller',
                        'controller' => 'System',
                        'action' => 'index',
                    ),
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
                            'route' => '[/:action[/:id][/page[/:page]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                "id" => '[a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(),
                        ),
                    ),
                ),
            ),

            'bbminwallet' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/bbmin/wallet',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Bbmin\Controller',
                        'controller' => 'Wallet',
                        'action' => 'wallets',
                    ),
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
                            'route' => '[/:action[/:id][/page[/:page]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                "id" => '[a-zA-Z0-9_-]*',
                                "page" => '[0-9]+',
                            ),
                            'defaults' => array(),
                        ),
                    ),
                ),
            ),

            'bbminsupport' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/bbmin/support',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Bbmin\Controller',
                        'controller' => 'Support',
                        'action' => 'index',
                    ),
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
                            'route' => '[/:action[/:id][/page[/:page]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                "id" => '[a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(),
                        ),
                    ),
                ),
            ),

            'bbmintraining' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/bbmin/training',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Bbmin\Controller',
                        'controller' => 'Training',
                        'action' => 'index',
                    ),
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
                            'route' => '[/:action[/:id][/page[/:page]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                "id" => '[a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(),
                        ),
                    ),
                ),
            ),

            'bbmintrainingjson' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/bbmin/trainingjson',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Bbmin\Controller',
                        'controller' => 'Trainingjson',
                        'action' => 'index',
                    ),
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
                                // 'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                "id" => '[a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(),
                        ),
                    ),

                    'course' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/coursejson/[/:action[/:programmeuid[/:id]]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'programmeuid' => '[a-zA-Z0-9_-]*',
                                "id" => '[a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(),
                        ),
                    ),
                ),
            ),

            'bbminproductjson' => array(
                'type' => 'Segment',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/bbmin/productjson[/:action[/:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        "id" => '[a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Bbmin\Controller',
                        'controller' => 'Productjson',
                        // 'action' => 'index'
                    ),
                ),
                'may_terminate' => true,
            ),

        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Bbmin' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
        'template_map' => array(
            'layout/adminlayout' => __DIR__ . '/../view/layout/adminlayout.phtml',
            'layout/admin-layout2' => __DIR__ . '/../view/layout/admin_layout.phtml',
            "bbmin_unsettled_order" => __DIR__ . '/../view/partial/bbmin/general/bbmin_unsettled_order_partial.phtml',

            // dashboard partials
            "bbmin_dashboard_recent_training" => __DIR__ . '/../view/partial/bbmin/dashboard/bbmin_dashboard_recent_training.phtml',
            "bbmin_dashboard_recent_user" => __DIR__ . '/../view/partial/bbmin/dashboard/bbmin_dashboard_recent_user_snippet.phtml',

            // sales
            'bbmin-view-order-invoice-snippet' => __DIR__ . '/../view/bbmin/sales/partials/bbmin-view-order-invoice-snippet.phtml',
            'bbmin-view-order-transaction-snippet' => __DIR__ . '/../view/bbmin/sales/partials/bbmin-view-order-transaction-snippet.phtml',
            'bbmin-view-order-customer-details-snippet' => __DIR__ . '/../view/bbmin/sales/partials/bbmin-view-order-customer-details-snippet.phtml',
            'bbmin-view-order-notify-payment-snippet' => __DIR__ . '/../view/bbmin/sales/partials/bbmin-view-order-notify-payment-snippet.phtml',

            // paginator
            "bbmin_footer_table_paginator" => __DIR__ . '/../view/partial/paginator/bbmin_footer_table_paginator.phtml',

        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            "bbmintopbarMenu" => "Bbmin\View\Helper\BBminLayoutTopBarMenu",

            // Customer
            "bbminCustomerStatusHelper" => "Bbmin\View\Helper\Customer\BbminCustomerStatusHelper",

            // Product
            "bbminProductBoolean" => BbminProductBoolenStateHelper::class,
            "bbminTrainingActivationActivehelper" => BbminTrainingActivationActiveHelper::class,
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            "Bbmin\Service\BbminService" => "Bbmin\Service\Factory\BbminServiceFactoryInterface",
            // Paginators
            "Bbmin\Paginator\CustomerAdapter" => "Bbmin\Paginator\Factory\CustomerAdapterFactoryInterface",
            "Bbmin\Paginator\CountryAdapter" => "Bbmin\Paginator\Factory\CountryAdapterFactory",
            "Bbmin\Paginator\TrainingAdminPaginator" => TrainingAdminPaginatorInterface::class,
            "Bbmin\Paginator\OrderAdminPaginator" => OrderAdminPaginatorFactory::class,
        ),
    ),

    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity',
                ),
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ),
            ),
        ),
    ),
);
