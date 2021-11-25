<?php
/**
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

return [
    // Development time modules
    'modules' => [
       
//         'Laminas\ApiTools\Admin',
//         "Laminas\ApiTools\Welcome",
//         'Laminas\ApiTools\Configuration',
    ],
    // development time configuration globbing
    'module_listener_options' => [
        'config_glob_paths' => ['config/autoload/{,*.}{global,local}-development.php'],
    ],
];