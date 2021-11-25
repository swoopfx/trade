<?php
namespace General;

use General\Form\Factory\DropzoneformFactory;
use General\Controller\Factory\GeneralControllerFactory;
use General\View\Helper\ViewResourceHelper;
use General\Paginator\PaginatorAdapter;
use General\Paginator\Factory\PaginatorAdapterFactory;

return array(
    'controllers' => array(
        'factories' => array(
            'General\Controller\GeneralController'=>GeneralControllerFactory::class
        ),
    ),
    "service_manager"=>array(
        "factories"=>array(
            "General\Service\GeneralService"=>"General\Service\Factory\GeneralServiceFactory",
            "General\Service\UploadService"=>"General\Service\Factory\UploadServiceFactory",
            
            // Redis Caheing
            "General\Cache\Redis"=>"General\Service\Factory\RedisCacheFactory",
            PaginatorAdapter::class=>PaginatorAdapterFactory::class
            
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
    ),
    "view_helpers"=>array(
        "invokables"=>array(
            "fieldsetViewHelper"=>"General\View\Helper\FieldsetViewHelper",
            "myCurrencyHelper"=>"General\View\Helper\MyCurrencyHelper",
            "imageHelper"=>"General\View\Helper\ImageViewHelper",
            "thumbnailImageHelper"=>"General\View\Helper\ThumbnailImageHelper",
            "fileIconViewHelper"=>ViewResourceHelper::class,
        )
    ),
    
    "form_elements"=>array(
        "factories"=>array(
            "dropzoneForm"=>DropzoneformFactory::class,
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'General' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            "general_dropzone_form"=> __DIR__ . '/../view/form/dropzoneform.phtml',
            "general_pagination"=> __DIR__ . '/../view/partial/general_pagination.phtml',
            "general-mail-default"=>__DIR__.'/../view/partial/general-mail-default.phtml'
           
            
        ),
    ),
    
    'router' => array(
        'routes' => array(
            
            'general' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/general',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'General\Controller',
                        'controller' => 'General',
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
            
            
            
           
        )
    ),
    
);