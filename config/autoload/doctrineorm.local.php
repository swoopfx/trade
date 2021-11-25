<?php
return array(
    'doctrine' => array(
        'connection' => array(
            // default connection name
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(

//                     'host' => 'localhost',
//                     'port' => '3306',
//                     'user' => 'tfits_tfits',
//                     'password' => 'seun1759@',
//                     'dbname' => 'tfit_retailer',

                    // 'host' => 'us-cdbr-azure-east-c.cloudapp.net',
                    // 'port' => '3306',
                    // 'user' => 'b7488980d7038c',
                    // 'password' => '45329998',
                    // 'dbname' => 'imapp',

                    // 'host' => '104.197.203.171',
                    // 'port' => '3306',
                    // 'user' => 'root',
                    // 'password' => 'Oluwaseun1',
                    // 'dbname' => 'imappcm',

                    'host' => '127.0.0.1',
                    'port' => '8889',
//                     'port' => '3306',
                    'user' => 'ezekiel',
                     'password' => 'Oluwaseun1@',  
                    'dbname' => 'trade',

                    'charset' => 'utf8', // extra
                    'driverOptions' => array(
                        1002 => 'SET NAMES utf8'
                    )
                )
            ),
            
//             "odm_default"=>[
                
//             ]
            // 'host' => 'localhost',
            // 'port' => '3306',
            // 'user' => 'mybroker',
            // 'password' => 'Oluwaseun1',
            // 'dbname' => 'acsm_58c8da08845533c',
        )
    )
);
