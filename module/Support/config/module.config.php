<?php
namespace Support;

return array(
    'controllers' => array(
    //         'invokables' => array(
        //             'Support\Controller\Support' => 'Support\Controller\SupportController',
        //         ),
        'factories' => array(
            'Support\Controller\Support' => 'Support\Controller\Factory\SupportControllerFactory',
            "Support\Controller\Supportmodal"=>"Support\Controller\Factory\SupportmodalControllerFactory"
        ),
    ),
    'router' => array(
        'routes' => array(
            'support' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/support',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Support\Controller',
                        'controller'    => 'Support',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action[/:id]]',
                            'constraints' => array(
                                'id' => '[a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
            
            'supportmodal' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/supportmodal',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Support\Controller',
                        'controller'    => 'Supportmodal',
                        'action'        => 'openticket',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action[/:id]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Support' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
        'template_map' => array(
            // view template
            "support-view-ticket-list-snippet"=> __DIR__ . '/../view/partials/support-view-ticket-list-snippet.phtml',
            // form template
            "support-fieldset"=> __DIR__ . '/../view/form/partials/support-fieldset.phtml',
            "support-wysiwyg-fieldset"=> __DIR__ . '/../view/form/partials/support-wysiwyg-editor.phtml',
            "support-messages-fieldset"=>__DIR__ . '/../view/form/partials/support-message-fieldset.phtml',
            "support-wysiwyg-form"=> __DIR__ . '/../view/form/support-wysiwyg-form.phtml',
            "support-messages-form"=> __DIR__ . '/../view/form/support-messages-form.phtml',
            "support-form"=> __DIR__ . '/../view/form/support-form.phtml',
        ),
    ),
    
    'view_helpers' => array(
        'invokables' => array(
            "supportStatusHelper"=>"Support\View\Helper\SupportStatusHelper",
            "supportStatusIndicator"=>"Support\View\Helper\SupportTicketIndicator",
            "supportTicketListHelper"=>"Support\View\Helper\SupportTicketListHelper",
        ),
    ),
    
    'service_manager' => array(
        'factories' => array(
            "Support\Service\SupportService"=>"Support\Service\Factory\SupportServiceFactory",
            
        ),
    ),
        "form_elements"=>array(
              "factories"=>array(
                      "Support\Form\Fieldset\SupportWYSIWYGFieldset"=>"Support\Form\Fieldset\Factory\SupportWYSIWYGFieldsetFactory",
                      "Support\Form\Fieldset\SupportMessageFieldset"=>"Support\Form\Fieldset\Factory\SupportMessageFieldsetFactory",
                      "Support\Form\Fieldset\SupportFieldset"=>"Support\Form\Fieldset\Factory\SupportFieldsetFactory",
    
                      //Form
                      "Support\Form\SupportWYSIWYGForm"=>"Support\Form\Factory\SupportWYSIWYGformFactory",
                      "Support\Form\SupportMessageForm"=>"Support\Form\Factory\SupportMessageFormFactory",
                      "Support\Form\SupportForm"=>"Support\Form\Factory\SupportFormFactory",
                  ),
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
);
