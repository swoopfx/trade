<?php
use VueHelper\View\Helper\VueFormHidden;

return array(
    'controllers' => array(
        'invokables' => array(
            'VueHelper\Controller\Vue' => 'VueHelper\Controller\VueController',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            "vueFormText"=>"VueHelper\View\Helper\VueFormText",
            "vueFormCheckBox"=>"VueHelper\View\Helper\VueFormCheckbox",
            "vueFormTextArea"=>"VueHelper\View\Helper\VueFormTextArea",
            "vueFormCollection"=>"VueHelper\View\Helper\VueFormCollection",
            "vueFormNumber"=>"VueHelper\View\Helper\VueFormNumber",
            "vueFormSelect"=>"VueHelper\View\Helper\VueFormSelect",
            "vueFormDate"=>"VueHelper\View\Helper\VueFormDate",
            "vueFormDatetime"=>"VueHelper\View\Helper\VueFormDatetime",
            "vueFormMultiCheckbox"=>"VueHelper\View\Helper\VueFormMultiCheckbox",
            "vueFormHidden"=>VueFormHidden::class,
            
            
        ),
    ),
    'router' => array(
        'routes' => array(
            'vue-helper' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/vue',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'VueHelper\Controller',
                        'controller'    => 'Vue',
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
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
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
            'VueHelper' => __DIR__ . '/../view',
        ),
    ),
);
