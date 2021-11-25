<?php
namespace Application;

use Application\Controller\Factory\ProductControllerFactory;

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    'router' => array(
        'routes' => array(
            
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/app',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:id]]',
                            'constraints' => array(
                                'id' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array()
                        )
                    )
                
                )
            ),
            
            'appmodal' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/appmodal',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Application',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:id]]',
                            'constraints' => array(
                                'id' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array()
                        )
                    )
                
                )
            ),
            
            'newproduct' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/np',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Product',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:id]]',
                            'constraints' => array(
                                'id' => '[a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array()
                        )
                    )
                    
                )
            ),
            
            'dashboard' => array(
                'type' => 'Laminas\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/dashboard',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'dashboard'
                    )
                )
            )
            
            
            
        )
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Laminas\Cache\Service\StorageCacheAbstractServiceFactory',
            'Laminas\Log\LoggerAbstractServiceFactory'
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator'
        ),
        "factories" => array(
            "Application\Service\ApplicationService" => "Application\Service\Factory\ApplicationServiceFactory"
        )
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo'
            )
        )
    ),
    'controllers' => array(
        // 'invokables' => array(
        
        // ),
        "factories" => array(
            'Application\Controller\Index' => 'Application\Controller\Factory\IndexControllerFactory',
            'Application\Controller\Product' => ProductControllerFactory::class,
            'Application\Controller\Application' => 'Application\Controller\Factory\ApplicationControllerFactory'
        )
    ),
    'controller_plugins' => array(
        'factories' => array(
            "redirectPlugin" => "Application\Controller\Plugin\Factory\RedirectPluginFactory"
        )
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/error.phtml',
            'navigation' => __DIR__ . '/../view/navigation/navigation.phtml',
            'admin-navigation' => __DIR__ . '/../view/navigation/admin-navigation.phtml',
            'shop-navigation' => __DIR__ . '/../view/navigation/shop-navigation.phtml',
            'layout/login' => __DIR__ . '/../view/layout/login.phtml',
            "layout/slim" => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
            
            // partials
            'application-pulsating-button' => __DIR__ . '/../view/partials/application-pulsating-profile.phtml',
            'application-no-profile-snippet' => __DIR__ . '/../view/partials/application-no-profile-snippet.phtml',
            'application-health-card' => __DIR__ . '/../view/partials/application-healtcard.phtml',
            'application-dashboard-sales-report' => __DIR__ . '/../view/partials/application-dashboard-sales-report.phtml',
            'application-dashboard-cart-order' => __DIR__ . '/../view/partials/application-dashboard-cart-order-snippet.phtml'
        
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array()
        )
    ),
    'view_helpers' => array(
        'invokables' => array(
            "nameOfUserHelper" => "Application\View\Helper\Dashboard\DashboardUserWelcomeHelper",
            
            // Dashboard
            "dashboardCarousel" => "Application\View\Helper\Dashboard\DashboardCarouselHelper",
            "dashoboardCartCount" => "Application\View\Helper\Dashboard\DashboardCartCount",
            
            // APP
            "appProfileOverviewHelper" => "Application\View\Helper\App\ApplicationProfileOverviewHelper",
            "appReferalOutstandingHelper" => "Application\View\Helper\App\ApplicationReferalOutstandingHelper"
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
