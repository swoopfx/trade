<?php
namespace Shop;

use Shop\Paginator\Factory\ProductConsumerAdapterInterface;
use Shop\Paginator\Factory\ProductCategoryAdapterInterface;
use Shop\Controller\Factory\ProductajaxControllerFactory;
use Shop\Service\Factory\CartItemServiceFactory;
use Shop\Service\Factory\DeliveryCalculatorServiceFactory;
use Shop\Service\Factory\OrderServiceFactory;
use Shop\Paginator\Factory\CustomerOrderAdapterFactory;
return array(
    'controllers' => array(
        
        // 'invokables' => array(
        // 'Shop\Controller\Shop' => 'Shop\Controller\ShopController',
        // ),
        'factories' => array(
            'Shop\Controller\Shop' => 'Shop\Controller\Factory\ShopControllerFactory',
            'Shop\Controller\Shopajax' => 'Shop\Controller\Factory\ShopajaxControllerFactory',
            'Shop\Controller\Product' => 'Shop\Controller\Factory\ProductControllerFactory',
            'Shop\Controller\Productajax'=>ProductajaxControllerFactory::class
        
        )
    ),
    
    'view_helpers' => array(
        'invokables' => array(
            "shopFooterAddressHelper" => "Shop\View\Helper\ShopFooterAddressHelper",
            
            // Products
            "shopProductCategorizeHelper" => "Shop\View\Helper\Product\ShopProductCategorizeHelper",
            "shopProductActivePrice"=>"Shop\View\Helper\Product\ShopProductActivePriceHelper",
            
            // Home
            
            // Dashboard
            "shopHomeMainCarouselHelper" => "Shop\View\Helper\Dashboard\ShopHomeMainCarouselHelper",
            "shopHomeSplashHelper" => "Shop\View\Helper\Dashboard\ShopHomeSpashHelper",
            "shopHomeLatestProducts"=>"Shop\View\Helper\Product\ShopProductLatestProductVIewHelper",
            
            // Wallet
            "shopWalletHighPointsProduct" => "Shop\View\Helper\Wallet\WalletHighPointProductHelper",
            "vueformcheckbox" => "Shop\View\Helper\Form\CheckboxVueHelper",
            "vueformText" => "Shop\View\Helper\Form\TextVuehelper"
        
        )
    ),
    
    'service_manager' => array(
        'factories' => array(
            "Shop\Service\ShopDashboardService" => "Shop\Service\Factory\ShopDashboardServiceFactory",
            "Shop\Service\ProductService" => "Shop\Service\Factory\ProductServiceFactory",
            "Shop\Service\CartService" => "Shop\Service\Factory\CartServiceFactory",
            "Shop\Service\CartItemService"=>CartItemServiceFactory::class,
            "Shop\Service\DeliveryCalculatorService"=>DeliveryCalculatorServiceFactory::class,
            "Shop\Service\OrderService"=>OrderServiceFactory::class,
            
            // Paginators
            "Shop\Paginator\ProductAdapter" => "Shop\Paginator\Factory\ProductAdapterInterface",
            "Shop\Paginator\ProductConsumerAdapter" => ProductConsumerAdapterInterface::class,
            "Shop\Paginator\ProductCategoryAdapter" => ProductCategoryAdapterInterface::class,
            "Shop\Paginator\CustomerOrderAdapter"=>CustomerOrderAdapterFactory::class,
        )
    ),
    'router' => array(
        'routes' => array(
            'shop' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/shopping',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Shop\Controller',
                        'controller' => 'Shop',
                        'action' => 'home'
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
                            'route' => '/[:action[/:id[/:vim]]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-zA-Z0-9_-]*',
                                'vim' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'category' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array()
                        )
                    )
                )
            ),
            
            'products' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/products',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Shop\Controller',
                        'controller' => 'Product',
                        'action' => 'all'
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
                            'route' => '/[:action[/:id[/:vim]]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-zA-Z0-9_-]*',
                                'vim' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'category' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array()
                        )
                    )
                
                )
            ),
            
            "product" => array(
                "type" => "segment",
                "options" => array(
                    'route' => '/product/:id[/:name]',
                    'constraints' => array(
                        'name' => '[a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Shop\Controller\Product',
                        'action' => 'product'
                    )
                )
            ),
            
            "cart" => array(
                "type" => "segment",
                "options" => array(
                    'route' => '/cart',
                    'constraints' => array(
                        'name' => '[a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Shop\Controller\Shop',
                        'action' => 'cart'
                    )
                )
            ),
            
            "checkout" => array(
                "type" => "segment",
                "options" => array(
                    'route' => '/checkout',
                    'constraints' => array(
                        'name' => '[a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Shop\Controller\Shop',
                        'action' => 'checkout'
                    )
                )
            ),
            
            "category" => array(
                "type" => "segment",
                "options" => array(
                    'route' => '/cat/:category[/:name]',
                    'constraints' => array(
                        
                        'name' => '[a-zA-Z0-9_-]*',
                        'category' => "[0-9]+"
                    ),
                    'defaults' => array(
                        'controller' => 'Shop\Controller\Shop',
                        'action' => 'category'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    
                    "pagination" => [
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/:action/:category[/:name[/page[/:page]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                "page" => "[0-9]+"
                            )
                        
                        )
                    ]
                
                )
            ),
            
            'shopajax' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/shopajax',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Shop\Controller',
                        'controller' => 'Shopajax',
                        'action' => 'topratedproductsajax'
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
                            'route' => '/[:action[/:id[/:vim]]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'vim' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array()
                        )
                    )
                )
            ),
            
            'productjax' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/productajax',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Shop\Controller',
                        'controller' => 'Productajax',
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
                            'route' => '/[:action[/:id[/:vim]]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-zA-Z0-9_-]*',
                                'vim' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array()
                        )
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Shop' => __DIR__ . '/../view'
        ),
        'strategies' => array(
            'ViewJsonStrategy'
        ),
        'template_map' => array(
            'layout/shop/home' => __DIR__ . '/../view/layout/home.phtml',
            'layout/shoperror' => __DIR__ . '/../view/error/shoperror.phtml',
            
            // partal templates
            'shop_product_description_fieldset' => __DIR__ . '/../view/partials/product/form/fieldset/shop_product_description_fieldset.phtml',
            "shop_product_fieldset" => __DIR__ . '/../view/partials/product/form/fieldset/shop_product_fieldset_snippet.phtml',
            "shop_product_feature_fieldset" => __DIR__ . '/../view/partials/product/form/fieldset/shop_product_features_fieldset.phtml',
            "shop_product_category_fieldset" => __DIR__ . '/../view/partials/product/form/fieldset/shop_product_category_fieldset_snippet.phtml',
            "shop_product_discount_fieldset" => __DIR__ . '/../view/partials/product/form/fieldset/shop_product_discount_fieldset.phtml',
            "shop_product_fieldset_summary" => __DIR__ . '/../view/partials/product/form/fieldset/shop_product_fieldset_summary.phtml',
            "shop_product_features_collection_fieldset" => __DIR__ . '/../view/partials/product/form/fieldset/shop_product_features_collection_fieldset.phtml',
            "shop_product_attribute_collection_fieldset" => __DIR__ . '/../view/partials/product/form/fieldset/shop_product_attribute_collection_fieldset.phtml',
            
            // Shop partials
            "shop_product_thumbnail_snippet" => __DIR__ . '/../view/partials/product/shop_product_thumbnail_snippet.phtml',
            
            //Email
            "shop-cash-checkout-email"=> __DIR__ . '/../view/email/shop-cash-checkout-email.phtml',
            "shop-checkout-template"=> __DIR__ . '/../view/email/shop-checkout-template.phtml',
            "shop-checkout-partial-basket-details"=> __DIR__ . '/../view/email/shop-checkout-partial-basket-details.phtml',
        
        )
    ),
    
    "form_elements" => array(
        "factories" => array(
            // Fieldset
            "Shop\Form\Fieldset\ProductDescriptionFieldset" => "Shop\Form\Fieldset\Factory\ProducDescriptionFactory",
            "Shop\Form\Fieldset\ProductDiscountFieldset" => "Shop\Form\Fieldset\Factory\ProductDiscountFieldsetFactory",
            "Shop\Form\Fieldset\ProductFeatureFieldset" => "Shop\Form\Fieldset\Factory\ProductFeatureFieldsetFactory",
            "Shop\Form\Fieldset\ProductFieldset" => "Shop\Form\Fieldset\Factory\ProductFieldsetFactory",
            "Shop\Form\Fieldset\ProductAttributesFieldset" => "Shop\Form\Fieldset\Factory\ProductAttributesFieldsetFactory",
            "Shop\Form\Fieldset\ProductCategoryFieldset" => "Shop\Form\Fieldset\Factory\ProductCategoryFieldsetFactory",
            "Shop\Form\Fieldset\ShopHomeSplashFieldset" => "Shop\Form\Fieldset\Factory\ShopHomeSpashFieldsetFactory",
            
            // Begin Form
            "Shop\Form\ProductForm" => "Shop\Form\Factory\ProductFormFactory",
            "Shop\Form\ShopHomeSplashForm" => "Shop\Form\Factory\ShopHomeSplashFormFactory",
            "Shop\Form\ProductCategoryForm" => "Shop\Form\Factory\ProductCategoryFormFactory",
            
            
        )
    
    ),
    
    'input_filters'=>array(
        "factories"=>array(
        // InputFilter
            "Shop\Form\Fieldset\ProductFieldsetInputFilter"=>"Shop\Form\Fieldset\Factory\ProductFieldsetInputFilterFactory",
            
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
