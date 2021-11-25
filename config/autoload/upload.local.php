<?php
return array(
    "cloudservice_upload" => array(
        /**
         * This is the default service used by the application
         * It is changable to options aws, gcp, azure
         */
        "default_service" => "aws",
        
        "service" => array(
            "aws" => array(
                'credentials' => [
                    'key' => 'AKIA6HLPYINC62YTNED2',
                    'secret' => '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'
                ],
//                 'credentials' => [
//                     'key' => 'AKIA6HLPYINC735EH4FD',
//                     'secret' => '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'
//                 ],
                'region' => 'change_me',
                'version' => 'latest',
                'DynamoDb' => [
                    'region' => 'another_region',
                    'version' => 'latest'
                ]
            ),
            "azure" => array(
                /**
                 * This defines configuration for the test environment on azure
                 */
                "test" => array(
                    "connection_string" => "UseDevelopmentStorage=true"
                ),
                
                /**
                 * This defines configuration for the live environment for
                 */
                "live" => array(
                    "connection_string" => "DefaultEndpointsProtocol=https;AccountName=imapp1diag388;AccountKey=uS2fxyYsdHHJsuzolG7RPVS3GgEV3qK8cdLjdNReKiz5PdbgEmzihCJJm76phDwWgTiRHmle3reaQa4xgIUTEA==;EndpointSuffix=core.windows.net"
                )
            ),
            "gcp" => array()
        )
    )
);
