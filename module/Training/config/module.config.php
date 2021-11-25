<?php
namespace Training;

use Training\Service\Factory\TrainingServiceFactory;
use Training\Form\Fieldset\Factory\TrainingFieldsetFactory;
use Training\Paginator\Factory\TrainingAdapterFactory;
use Training\Service\Factory\ProgrammesServiceFactory;
use Training\Form\Fieldset\Factory\CourseFieldsetFactory;
use Training\Form\Factory\CourseFormFactory;
use Training\Controller\Factory\ClassroomControllerFactory;
use Training\Service\Factory\ClassroomServiceFactory;
use Training\Form\Fieldset\Factory\SubmitMilestoneAnswerFieldsetFactory;
use Training\Form\Factory\SubmitMilestoneAnswerForm;
use Training\Service\Factory\YoutubeApiServiceFactory;
use Training\Service\YoutubeApiService;
return array(
    'controllers' => array(
        'invokables' => array(
            // 'Training\Controller\Training' => 'Training\Controller\TrainingController'
        ),
        'factories' => array(
            "Training\Controller\Training" => "Training\Controller\Factory\TrainingControllerFactory",
            "Training\Controller\Classroom" => "Training\Controller\Factory\ClassroomControllerFactory",
            "Training\Controller\Trainingjson" => "Training\Controller\Factory\TrainingjsonControllerFactory"
        )
    ),
    'router' => array(
        'routes' => array(
            'training' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/training',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Training\Controller',
                        'controller' => 'Training',
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
                                'id' => '[a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array()
                        )
                    ),
                    "pagination" => [
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:action[/page[/:page]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                "page" => "[0-9]+"
                            )
                            
                        )
                    ]
                )
            ),
            
            
            'classroom' => array(
                'type' => 'segment',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/classroom/:trainingUid',
                    'constraints' => array(
                        'trainingUid' => '[a-zA-Z0-9_-]*',
//                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Training\Controller',
                        'controller' => 'Classroom',
                        'action' => 'room'
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
                                'id' => '[a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array()
                        )
                    )
                )
            ),
            
            
            'trainingjson' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/trainingjson',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Training\Controller',
                        'controller' => 'Trainingjson',
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
                            'route' => '[/:action[/:id][/page[/:page]]]',
                            'constraints' => array(
                                'id' => '[a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
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
            'Training' => __DIR__ . '/../view'
        ),
        'strategies' => array(
            'ViewJsonStrategy'
        ),
        'template_map' => array(
            "training_in_progress_list" => __DIR__ . '/../view/training/partials/training_in_progress_list_snippet.phtml',
            "training_recent_list" => __DIR__ . '/../view/training/partials/training_recent_snippet_list.phtml',
            "training_reward_information_modal" => __DIR__ . '/../view/training/partials/training_reward_information_modal.phtml',
            "training_footer_pagination_control" => __DIR__ . '/../view/training/partials/training_footer_pagination_control.phtml',
            "training-list-course-snippet"=>__DIR__ . '/../view/training/partials/training-courses-list-snippet.phtml',
            "training-milestone-resources-list-snippet"=>__DIR__ . '/../view/training/partials/training-milestone-resources-list-snippet.phtml',
            
            
            // Fieldset
            "course_fieldset_snippet" => __DIR__ . '/../view/training/partials/form/fieldset/course_fieldset_snippet.phtml',
            "training-user-wysiwyg-submit-answer-fieldset-snippet" => __DIR__ . '/../view/training/partials/form/fieldset/training-user-wysiwyg-submit-answer-fieldset-snippet.phtml',
            
            // Form
            "course_form_snippet" => __DIR__ . '/../view/training/partials/form/course_form_snippet.phtml',
            "training-user-wysiwyg-submit-answer-form" => __DIR__ . '/../view/training/partials/form/training-user-wysiwyg-submit-answer-form.phtml',
            
            // mail
            "training-begin-journey-mail" => __DIR__ . '/../view/training/email/training-begin-shopping-email.phtml',
            "training-submitted-milestone-email" => __DIR__ . '/../view/training/email/training-submitted-milestone-email.phtml',
            
        )
    
    ),
    'view_helpers' => array(
        'invokables' => array(
            "trainingStatusHelper" => "Training\View\Helper\TrainingStatusHelper"
        )
    ),
    
    "form_elements" => array(
        "factories" => array(
            
            // Feidldsets
            "Training\Form\Fieldset\TrainingFieldset" => TrainingFieldsetFactory::class,
            "Training\Form\Fieldset\CourseFieldset" => CourseFieldsetFactory::class,
            "Training\Form\Fieldset\SubmitMilestoneAnswerFieldset" => SubmitMilestoneAnswerFieldsetFactory::class,
            
            // Form
            "Training\Form\CourseForm" => CourseFormFactory::class,
            "Training\Form\SubmiMilestoneAnswerForm" => SubmitMilestoneAnswerForm::class,
            
        )
    ),
    
    'service_manager' => array(
        'factories' => array(
            "Training\Service\TrainingService" => TrainingServiceFactory::class,
            "Training\Service\ProgrammesService" => ProgrammesServiceFactory::class,
            "Training\Service\ClassroomService" => ClassroomServiceFactory::class,
            
            // Adapter
            "Training\Paginator\TrainingAdapter" => TrainingAdapterFactory::class,
            "Training\Service\YoutubeApiService"=>YoutubeApiServiceFactory::class
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
