<?php
return array(
    "navigation" => array(
        "default" => array(
            [
                'label' => '<i class="icon fa fa-home fa-2x"></i>
              <span>Dashboard</span>',
                'route' => 'dashboard',
                'controller' => 'Application\Controller\Index',
                'action' => 'dashboard',
                'resource' => 'Application\Controller\Index',
                'privilege' => 'dashboard'
                //

            ],
            [
                'label' => '<i class="icon fa fa-money fa-2x"></i>
              <span>Wallet</span>',
                'route' => 'wallet/default',
                'controller' => 'Wallet',
                'action' => 'index',
                'resource' => 'Wallet\Controller\Wallet',
                'privilege' => 'index'

            ],
            [
                'label' => '<i class="icon fa fa-bank fa-2x"></i>
              <span>Training</span>',
                'route' => 'training/default',
                'controller' => 'Tarining',
                'action' => 'index',
                'resource' => 'Training\Controller\Training',
                'privilege' => 'index'
                
            ],

            [
                'label' => '<i class="icon fa fa-shopping-cart fa-2x"></i>
              <span>Shop</span>',
                'route' => 'shop',
                'controller' => 'Shop',
                "target"=>"_blank",
                'action' => 'dashboard',
                'resource' => 'Shop\Controller\Shop',
                'privilege' => 'home'

            ],

//             [
//                 'label' => '<i class="icon fa fa-user fa-2x"></i><span>Support</span>',
//                 'route' => 'support',
//                 'controller' => 'Support',
//                 'action' => 'index',
//                 'resource' => 'Support\Controller\Support',
//                 'privilege' => 'index'

//             ]
        ),

        "admin" => array(
            [
                'label' => '<i class="icon fa fa-home fa-2x"></i>
              <span>Dashboard</span>',
                'route' => 'bbmin/default',
                // 'controller' => 'Application\Controller\Index',
                'action' => 'index',
                // 'resource' => 'Application\Controller\Index',
                // 'privilege' => 'dashboard'
                // //

            ],

            [
                'label' => '<i class="icon fa fa-shopping-cart fa-2x"></i>
              <span>Shop</span>',
                'route' => 'bbminshop/default',
                "pages" => [
//                     [
//                         'label' => 'Category',
//                         'route' => 'bbminshop/default',
//                         'params' => [
//                             'action' => 'category'
//                         ]
//                     ],

                    [
                        'label' => 'Shop Board',
                        'route' => 'bbminshop/default',
                        'params' => [
                            'action' => 'board'
                        ]
                    ],

                    [
                        'label' => 'Product',
                        'route' => 'bbminshop/default',
                        'params' => [
                            'action' => 'product'
                        ]
                    ],

                    [
                        'label' => 'Shop Settings',
                        'route' => 'dashboard'
                        // 'params' => [
                        // 'action' => 'all'
                        // ]
                    ]

                ]

            ],

            // Begin Wallet
            [
                'label' => '<i class="icon fa fa-money-bill-alt fa-2x"></i>
              <span>Wallet</span>',
                'route' => 'bbminwallet/default',
                "pages" => [

                    [
                        'label' => 'Wallets',
                        'route' => 'bbminwallet/default',
                        'params' => [
                            'action' => 'wallets'
                        ]
                    ],

                    [
                        'label' => 'Activity',
                        'route' => 'bbminwallet/default',
                        'params' => [
                            'action' => 'activity'
                        ]
                    ],

                    [
                        'label' => 'Wallet Report',
                        'route' => 'bbminwallet/default',
                        'params' => [
                            'action' => 'report'
                        ]
                    ]

                ]

            ],
            // End Wallet

            // Begin Customer
            [
                'label' => '<i class="icon fa fa-user fa-2x"></i>
              <span>Customer</span>',
                'route' => 'bbmincustomer/default',
                "pages" => [

                    [
                        'label' => 'Customer List',
                        'route' => 'bbmincustomer/default',
                        'params' => [
                            'action' => 'all'
                        ]
                    ],

                    [
                        'label' => 'Customer BlackList',
                        'route' => 'bbmincustomer/default',
                        'params' => [
                            'action' => 'blacklist'
                        ]
                    ],
                    
                    [
                        'label' => 'Customer Statistics',
                        'route' => 'bbmincustomer/default',
                        'params' => [
                            'action' => 'statistics'
                        ]
                    ],

                ]

            ],
            // End Cutomer
            
            
            // Begin Customer
            [
                'label' => '<i class="icon fa fa-user fa-2x"></i>
              <span>Training</span>',
                'route' => 'bbmintraining/default',
                "pages" => [
                    
                    [
                        'label' => 'Create Training',
                        'route' => 'bbmintraining/default',
                        'params' => [
                            'action' => 'create'
                        ]
                    ],
                    
                    [
                        'label' => 'View Trainings',
                        'route' => 'bbmintraining/default',
                        'params' => [
                            'action' => 'view'
                        ]
                    ],
                    
                    [
                        'label' => 'Submited Assignment',
                        'route' => 'bbmintraining/default',
                        'params' => [
                            'action' => 'assignments'
                        ]
                    ],
                    
                ]
                
            ],
            // End Cutomer
            
            

            // Begin Sales
            [
                'label' => '<i class="icon fa fa-cart-plus fa-2x"></i><span>Sales</span>',
                'route' => 'bbminsales/default',
                "pages" => [

                    [
                        'label' => 'Orders',
                        'route' => 'bbminsales/default',
                        'params' => [
                            'action' => 'order'
                        ]
                    ],

                    [
                        'label' => 'Returns',
                        'route' => 'bbminsales/default',
                        'params' => [
                            'action' => 'returns'
                        ]
                    ],

                    [
                        'label' => 'Report',
                        'route' => 'bbminsales/default',
                        'params' => [
                            'action' => 'report'
                        ]
                    ]

                ]

            ],
            // End Sales

            // Begin Shop
            [
                'label' => '<i class="icon fa fa-user fa-2x"></i>
              <span>Support</span>',
                'route' => 'bbminsupport/default',
                "pages" => [

                    [
                        'label' => 'View Tickets',
                        'route' => 'bbminsupport/default',
                        'params' => [
                            'action' => 'view'
                        ]
                    ],

                    [
                        'label' => 'Expired Policy',
                        'route' => 'bbminsupport/default',
                        'params' => [
                            'action' => 'manage'
                        ]
                    ],

//                     [
//                         'label' => 'Cover Note',
//                         'route' => 'dashboard'
//                         // 'params' => [
//                         // 'action' => 'all'
//                         // ]
//                     ]

                    // [
                    // 'label' => 'Unpublished Policy',
                    // 'route' => 'policy/default',
                    // 'params' => [
                    // 'action' => 'floatall'
                    // ]
                    // ],
                    // [
                    // 'label' => 'Generate Policy',
                    // 'route' => 'policy'
                    // ]
                ]

            ],
            // End Shop
            [
                'label' => '<i class="icon fa fa-chart-area  fa-2x"></i><span>Marketing</span>',
                'route' => 'bbminmarket/default',
                "pages" => [

                    [
                        'label' => 'Event',
                        'route' => 'bbminmarket/default',
                        'params' => [
                            'action' => 'event'
                        ]
                    ],

                    [
                        'label' => 'Bonus',
                        'route' => 'bbminmarket/default',
                        'params' => [
                            'action' => 'bonus'
                        ]
                    ],

                    [
                        'label' => 'Coupons',
                        'route' => 'bbminmarket/default',
                        'params' => [
                            'action' => 'coupons'
                        ]
                    ],

                    [
                        'label' => 'Activity',
                        'route' => 'bbminmarket/default',
                        'params' => [
                            'action' => 'activity'
                        ]
                    ]
                    // [
                    // 'label' => 'Generate Policy',
                    // 'route' => 'policy'
                    // ]
                ]

            ],
            // Begin System
            [
                'label' => '<i class="icon fa fa-cogs  fa-2x"></i><span>System</span>',
                'route' => 'bbminsystem/default',
                "pages" => [

                    [
                        'label' => 'Settings',
                        'route' => 'bbminsystem/default',
                        'params' => [
                            'action' => 'settings'
                        ]
                    ],

                    [
                        'label' => 'Maintenance',
                        'route' => 'bbminsystem/default',
                        'params' => [
                            'action' => 'maintenance'
                        ]
                    ]

                    // [
                    // 'label' => 'Cover Note',
                    // 'route' => 'dashboard'
                    // // 'params' => [
                    // // 'action' => 'all'
                    // // ]
                    // ]

                    // [
                    // 'label' => 'Unpublished Policy',
                    // 'route' => 'policy/default',
                    // 'params' => [
                    // 'action' => 'floatall'
                    // ]
                    // ],
                    // [
                    // 'label' => 'Generate Policy',
                    // 'route' => 'policy'
                    // ]
                ]

            ],

            [
                'label' => '<i class="icon fa fa-question-circle fa-2x"></i>
              <span>FAQ</span>',
                'route' => 'wallet/default'

            ]
        ),

        "shop" => array(
//             [
//                 'label' => '<i class="icon fa fa-home fa-2x"></i>
//               <span>Dashboard</span>',
//                 'route' => 'dashboard',
//                 'controller' => 'Index',
//                 // 'action' => 'dashboard',
//                 'resource' => 'Application\Controller\Index',
//                 'privilege' => 'dashboard'
//                 //

//             ],
//             [
//                 'label' => '<i class="icon fa fa-money fa-2x"></i>
//               <span>Wallet</span>',
//                 'route' => 'wallet/default',
//                 'controller' => 'Wallet',
//                 'action' => 'index',
//                 'resource' => 'Wallet\Controller\Wallet',
//                 'privilege' => 'index'

//             ],
            [
                'label' => '<i class="icon fa fa-home fa-2x"></i>
              <span>Home</span>',
                'route' => 'shop',
                // 'controller' => 'Category',
                'action' => 'd',
                'resource' => 'Application\Controller\Index',
                // 'privilege' => 'home',
                "pages" => [
                    [
                        'label' => '<i class="icon fa fa-home fa-2x"></i>
              <span>Dashboard</span>',
                        'route' => 'dashboard',
                        'controller' => 'Application\Controller\Index',
                        'action' => 'dashboard',
                        'resource' => 'Application\Controller\Index',
                        'privilege' => 'dashboard'
                        
                        
                        
                    ],
                    [
                        'label' => '<i class="icon fa fa-money fa-2x"></i>
              <span>Wallet</span>',
                        'route' => 'wallet/default',
                        'controller' => 'Wallet',
                        'action' => 'index',
                        'resource' => 'Wallet\Controller\Wallet',
                        'privilege' => 'index'


                     
                    ],
                    
                    [
                        'label' => '<i class="icon fa fa-bank fa-2x"></i>
              <span>Training</span>',
                        'route' => 'training/default',
                        'controller' => 'Tarining',
                        'action' => 'index',
                        'resource' => 'Training\Controller\Training',
                        'privilege' => 'index'
                    ]
                ]
                
            ],

            [
                'label' => '<i class="icon fa fa-shopping-cart fa-2x"></i>
              <span>Shop</span>',
                'route' => 'shop',
                // 'controller' => 'Category',
                'action' => 'dashboard',
                'resource' => 'Shop\Controller\Shop',
                // 'privilege' => 'home',
                "pages" => 
                [
                    [
                        'label' => 'Shop Home',
                        'route' => 'shop',
//                         "params" => [
//                             "action" => "shop-category",
//                             "category"=>"100",
//                             "name"=>"men"
//                         ]
                    ],
                    [
                        'label' => 'Category',
                        'route' => 'products/default',
                        "params" => [
                            "action" => "categorize",
//                             "category"=>"100",
//                             "name"=>"men"
                        ]
                    ],

//                     [
//                         'label' => "Sales",
//                         'route' => 'shop/default',
//                         "params" => [
//                             "action" => "sales",
//                             "category"=>"200",
//                             "name"=>"women"
//                         ]
//                     ],

//                     [
//                         'label' => 'Collections',
//                         'route' => 'category',
//                         "params" => [
//                             "action" => "category",
//                             "category"=>"200",
//                             "name"=>"women"
//                         ]
//                     ]
                ]

            ],

//             [
//                 'label' => '<i class="icon fa fa-user fa-2x"></i><span>Support</span>',
//                 'route' => 'support',
//                 'controller' => 'Index',
//                 'action' => 'dashboard',
//                 'resource' => 'Support\Controller\Support',
//                 'privilege' => 'index'

//             ]
        )

    ),

    "service_manager" => array(
        'abstract_factories' => array(
            'Laminas\Navigation\Service\NavigationAbstractServiceFactory'
        )
    )
);