<?php
use Doctrine\ODM\MongoDB\Configuration;

return array(
    'doctrine' => array(
        
//         'connection' => array(
//             'odm_default' => array(
//                 'server' => 'localhost',
//                 'port' => '27017',
//                 // 'connectionString' => null,
//                 // 'user' => null,
//                 // 'password' => null,
//                 'dbname' => "tanim"
//                 // 'options' => array()
//             )
//         ),
        
//         'configuration' => array(
//             'odm_default' => array(
//                 'metadata_cache' => 'array',
                
//                 'driver' => 'odm_default',
                
//                 'generate_proxies' => true,
//                 'proxy_dir' => 'data/DoctrineMongoODMModule/Proxy',
//                 'proxy_namespace' => 'DoctrineMongoODMModule\Proxy',
                
//                 'generate_hydrators' => true,
//                 'hydrator_dir' => 'data/DoctrineMongoODMModule/Hydrator',
//                 'hydrator_namespace' => 'DoctrineMongoODMModule\Hydrator',
                
//                 'generate_persistent_collections' => Configuration::AUTOGENERATE_ALWAYS,
//                 'persistent_collection_dir' => 'data/DoctrineMongoODMModule/PersistentCollection',
//                 'persistent_collection_namespace' => 'DoctrineMongoODMModule\PersistentCollection',
//                 'persistent_collection_factory' => null,
//                 'persistent_collection_generator' => null,
                
//                 'default_db' => null,
                
//                 'filters' => array(), // array('filterName' => 'BSON\Filter\Class'),
                
//                 'logger' => null // 'DoctrineMongoODMModule\Logging\DebugStack'
//             )
//         ),
        
//         'driver' => array(
//             'odm_default' => array(
//                 'drivers' => array(
//                     'drivers' => array(
//                         'Shop\Document' => 'shopcart'
//                     )
//                 )
//             ),
            
//             'shopcart' => array(
//                 'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
// //                 'cache' => 'array',
//                 'paths' => array(
//                     'module/Shop/src/Shop/Document'
//                 )
//             )
//         ),
        
//         'documentmanager' => array(
//             'odm_default' => array(
//                 'connection' => 'odm_default',
//                 'configuration' => 'odm_default',
//                 'eventmanager' => 'odm_default'
//             )
//         ),
        
//         'eventmanager' => array(
//             'odm_default' => array(
//                 'subscribers' => array()
//             )
//         )
    )
);
