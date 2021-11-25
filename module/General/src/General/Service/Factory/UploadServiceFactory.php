<?php
namespace General\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use General\Service\UploadService;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use Aws\S3\S3Client;
use Google\Cloud\Storage\StorageClient;
use ZendService\Amazon\S3\S3;

/**
 *
 * @author otaba
 *        
 */
class UploadServiceFactory implements FactoryInterface
{

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get("Config");
        $xserv = new UploadService();
        /**
         *
         * @var \General\Service\GeneralService $generalService
         */
        $generalService = $serviceLocator->get("General\Service\GeneralService");
        
        $uploadService = $config["cloudservice_upload"]["default_service"];
        
        $xserv->setAwsConnection($this->initAwsBlob($config))
            ->setAzureConnection($this->initAzureBlob($config))
            ->setSpecificService($uploadService)
            ->setEntityManager($generalService->getEntityManager())
            ->setGcpConnection($this->initGcpBlob($config));
        
        return $xserv;
    }

    /**
     * This initializes and returns the inconnection for Azure
     *
     * @param array $config            
     * @return \MicrosoftAzure\Storage\Blob\BlobRestProxy
     */
    private function initAzureBlob(array $config)
    {
        $connectionString = (getenv("APP_ENV") == "development" ? $config["cloudservice_upload"]["service"]["azure"]["test"]["connection_string"] : $config["cloudservice_upload"]["service"]["azure"]["live"]["connection_string"]);
        $client = BlobRestProxy::createBlobService($connectionString);
        return $client;
    }

    private function initAwsBlob($config)
    {
        $client = new S3($config["cloudservice_upload"]["service"]["aws"]["credentials"]["key"], $config["cloudservice_upload"]["service"]["aws"]["credentials"]["secret"]);
//         $connectionString = ($_SERVER["APPLICATION_ENV"] == "development" ? $config["cloudservice_upload"]["service"]["aws"]["test"] : $config["cloudservice_upload"]["service"]["aws"]["live"]);
//         $client = Mappin
        return $client;
    }

    /**
     * Connection for GCP
     *
     * @param array $config            
     * @return \Google\Cloud\Storage\StorageClient
     */
    private function initGcpBlob($config)
    {
        $connectionString = '{
    "type": "service_account",
    "project_id": "[PROJECT-ID]",
    "private_key_id": "[KEY-ID]",
    "private_key": "-----BEGIN PRIVATE KEY-----\n[PRIVATE-KEY]\n-----END PRIVATE KEY-----\n",
    "client_email": "[SERVICE-ACCOUNT-EMAIL]",
    "client_id": "[CLIENT-ID]",
    "auth_uri": "https://accounts.google.com/o/oauth2/auth",
    "token_uri": "https://accounts.google.com/o/oauth2/token",
    "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
    "client_x509_cert_url": "https://www.googleapis.com/robot/v1/metadata/x509/[SERVICE-ACCOUNT-EMAIL]"
    }';
        
        // $client = new StorageClient(array(
        // 'keyFile' => json_decode($connectionString, true)
        // ));
        
        // return $client;
    }
}

