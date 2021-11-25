<?php
namespace User;

return array(
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
    "form_elements"=>array(
        "factories"=>array(
            "User\Form\Fieldset\UserProfileFieldset"=>"User\Form\Fieldset\Factory\UserProfileFieldsetFactory",
            "User\Form\UserProfileForm"=>"User\Form\Factory\UserProfileFormFactory",
        )
    ),
    'view_manager' => array(
        'template_map' => array(
            // fieldset
            "user-user-profile-fieldset"=>__DIR__ . '/../view/form/fieldset/user-user-fieldset-snippet.phtml',
            
            
            // form 
            "user-user-profile-form"=>__DIR__.'/../view/form/user-user-profile-form-snippet.phtml'
        ),
        'template_path_stack' => array(
            'User' => __DIR__ . '/../view'
        ), 
    ),
);