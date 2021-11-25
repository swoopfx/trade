<?php
namespace General\Service;

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use Doctrine\ORM\EntityManager;
use Aws\S3\S3Client;
use Google\Cloud\Storage\StorageClient;
use Shop\Entity\Image;
use MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;
use MicrosoftAzure\Storage\Common\Internal\Resources;
use Imagine\Imagick\Imagine;
use Imagine\Image\Box;
use ZendService\Amazon\S3\S3;

/**
 *
 * @author otaba
 *        
 */
class UploadService
{

    /**
     * Identifies which of the service is being used
     * options are azure, gcp or aws
     *
     * @var string
     */
    private $specificService;

    /**
     *
     * @var BlobRestProxy
     */
    private $azureConnection;

    /**
     *
     * @var S3
     */
    private $awsConnection;

    /**
     *
     * @var StorageClient
     */
    private $gcpConnection;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    const CONTAINER_NAME = "tfitsonline";

    const UPLOAD_SERVICE_AWS = "aws";

    const UPLOAD_SERVICE_AZURE = "azure";

    const UPLOAD_SERVICE_GCP = "gcp";

    const MAX_FILE_SIZE = 10582853;

    const IMAGE_LOW_RES_MINIMUM_WIDTH = 700;

    const IMAGE_THUMBNAIL_MINIMUM_WIDTH = 400;

    // Image
    const JPEG_MIME_TYPE = "image/jpeg";

    const PNG_MIME_TYPE = "image/png";

    const BMP_MIME_TYPE = "image/bmp";

    const GIF_MIME_TYPE = "image/gif";

    // 10 MB
    
    // Azure Config
    const GENERAL_LIVE_AZURE_BLOB_URL = "";

    const UPLOAD_DEMO_AZURE_BLOB_URI = "http://" . Resources::EMULATOR_BLOB_URI;

    const UPLOAD_DEMO_AZURE_DEV_STORE_NAME = Resources::DEV_STORE_NAME;

    const UPLOAD_DEMO_AZURE_BLOB_FULL_URL = UploadService::UPLOAD_DEMO_AZURE_BLOB_URI . "/" . UploadService::UPLOAD_DEMO_AZURE_DEV_STORE_NAME;

    // Binary Data
    const BINARY_MIME_TYPE = "application/octet-stream";

    protected $error_messages = array(
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE (10MB) specified',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk'
    );

    private function cleanBlobName($name)
    {
        $name = str_replace(" ", "-", $name);
        $name = time() . "_" . $name;
        return $name;
    }

    private function thumbnailBlobName($name)
    {
        $name = str_replace(" ", "-", $name);
        $name = time() . "_thumb_" . $name;
        return $name;
    }

    private function lowResBlobName($name)
    {
        $name = str_replace(" ", "-", $name);
        $name = time() . "_lowres_" . $name;
        return $name;
    }

    /**
     * This uploads into the microsoft azure container 'tfitsonline'
     *
     * @param array $file            
     * @throws \Exception
     * @return \Shop\Entity\Image|string
     */
    protected function uploadintoAzure(array $file)
    {
        $em = $this->entityManager;
        $imageEntity = new Image();
        
        $blobName = $this->cleanBlobName($file["name"]);
        $thumnailName = $this->thumbnailBlobName($file['name']);
        
        $lowResName = $this->lowResBlobName($file['name']);
        $imageSize = getimagesize($file['tmp_name']); // returns the dension array of the file width/ height
        
        if ($file["size"] > UploadService::MAX_FILE_SIZE) {
            // Trigger an event
            throw new \Exception($this->error_messages[2]);
        } elseif ($imageSize[0] < self::IMAGE_LOW_RES_MINIMUM_WIDTH) {
            throw new \Exception("Image width should not be less than " . self::IMAGE_LOW_RES_MINIMUM_WIDTH . "px");
        } elseif ($imageSize[0] > 3000) {
            throw new \Exception("Image width should not be more than 3000px");
        } elseif ($file['tmp_name'] == NULL) {
            throw new \Exception($this->error_messages[4]);
        } else {
            
            $content = fopen($file['tmp_name'], 'r');
            
            $blobOptions = new CreateBlockBlobOptions();
            $blobOptions->setContentType($file["type"]);
            $res = $this->azureConnection->createBlockBlob(UploadService::CONTAINER_NAME, $blobName, $content, $blobOptions);
            // create thumbnail
            $thumbnail = $this->createThumbnail($file['tmp_name']);
            $lowResolution = $this->createLowerresolution($file['tmp_name']);
            $thumb = $this->azureConnection->createBlockBlob(UploadService::CONTAINER_NAME, $thumnailName, $thumbnail, $blobOptions);
            $thumb = $this->azureConnection->createBlockBlob(UploadService::CONTAINER_NAME, $lowResName, $lowResolution, $blobOptions);
            
            if ($res != NULL) {
                
                $loadUri = (getenv("APP_ENV") == "development" ? self::UPLOAD_DEMO_AZURE_BLOB_FULL_URL : self::GENERAL_LIVE_AZURE_BLOB_URL);
                
                $docUrl = $loadUri . "/" . UploadService::CONTAINER_NAME . "/" . $blobName;
                $thumbImage = $loadUri . "/" . UploadService::CONTAINER_NAME . "/" . $thumnailName;
                $lowResImage = $loadUri . "/" . UploadService::CONTAINER_NAME . "/" . $lowResName;
                $mimeType = $file["type"];
                
                // $docEntity->setCreatedOn(new \DateTime())
                // ->setDocUrl($docUrl)
                // ->setMimeType($mimeType)
                // ->setDocName($blobName)
                // ->setIsHidden(false)
                // ->setIsConfirmed(false);
                
                $imageEntity->setCreatedOn(new \DateTime())
                    ->setThumbnail($thumbImage)
                    ->setImageUrl($docUrl)
                    ->setImageName($blobName)
                    ->setLowres($lowResImage)
                    ->setImageUid(self::ImageUid())
                    ->setIsHidden(FALSE)
                    ->setMimeType($mimeType);
                
                return $imageEntity;
            }
        }
    }

    protected function uploadDocumentToAws(array $file, string $path = "document")
    {
        $fullPath = self::CONTAINER_NAME . '/' . $path;
        $em = $this->entityManager;
        $imageEntity = new Image();
        
        $documentSize = $file['size'];
        
        if ($documentSize > self::MAX_FILE_SIZE) {
            throw new \Exception($this->error_messages[2]);
        } else {
            $content = fopen($file['tmp_name'], 'r');
            $file['name'] = $this->cleanBlobName($file["name"]);
            
            try {
                $this->awsConnection->putObject($fullPath . '/' . $file['name'], $content, [
                    S3::S3_ACL_HEADER => S3::S3_ACL_PUBLIC_READ
                ]);
            } catch (\Exception $e) {
                // var_dump($e->getMessage());
                // return $e->getMessage();
            }
            
            $loadUri = $this->awsConnection->getEndpoint();
            $docUrl = $loadUri . "/" . $fullPath . '/' . $file['name'];
            
            $mimeType = $file["type"];
            
            $imageEntity->setCreatedOn(new \DateTime())
                ->setImageUrl($docUrl)
                ->setImageName($file['name'])
                ->setImageUid(self::ImageUid())
                ->setIsHidden(FALSE)
                ->setMimeType($mimeType);
            
            return $imageEntity;
        }
    }

    protected function uploadToAws(array $file, string $path = 'upload')
    {
        // $this->awsConnection->createBucket(self::CONTAINER_NAME);
        $fullPath = self::CONTAINER_NAME . '/' . $path;
        $em = $this->entityManager;
        $imageEntity = new Image();
        
        $imageSize = getimagesize($file['tmp_name']); // returns the dension array of the file width/ height
        
        if ($file["size"] > UploadService::MAX_FILE_SIZE) {
            // Trigger an event
            throw new \Exception($this->error_messages[2]);
        } // elseif ($imageSize[0] < self::IMAGE_LOW_RES_MINIMUM_WIDTH) {
          // throw new \Exception("Image width should not be less than " . self::IMAGE_LOW_RES_MINIMUM_WIDTH . "px");
          // }
        elseif ($imageSize[0] > 3000) {
            throw new \Exception("Image width should not be more than 3000px");
        } elseif ($file['tmp_name'] == NULL) {
            throw new \Exception($this->error_messages[4]);
        } else {
            
            $content = fopen($file['tmp_name'], 'r');
            $file['name'] = $this->cleanBlobName($file["name"]);
            
            $lowResPath = $fullPath . "/lowres";
            $thumbnailpath = $fullPath . "/thumbnail";
            
            $thumbnail = $this->createThumbnail($file['tmp_name']);
            $lowResolution = $this->createLowerresolution($file['tmp_name']);
            
            // var_dump($thumbnail);
            
            // $file["name"] = $this->cleanBlobName($file["name"]);
            try {
                $this->awsConnection->putObject($fullPath . '/' . $file['name'], $content, [
                    S3::S3_ACL_HEADER => S3::S3_ACL_PUBLIC_READ
                ]);
            } catch (\Exception $e) {
                // var_dump($e->getMessage());
            }
            
            try {
                $thumbnaiName = $this->thumbnailBlobName($file['name']);
                $this->awsConnection->putObject($thumbnailpath . '/' . $thumbnaiName, $thumbnail, [
                    S3::S3_ACL_HEADER => S3::S3_ACL_PUBLIC_READ
                ]);
            } catch (\Exception $e) {}
            
            try {
                $lowResolutionName = $this->lowResBlobName($file['name']);
                $this->awsConnection->putObject($lowResPath . '/' . $lowResolutionName, $lowResolution, [
                    S3::S3_ACL_HEADER => S3::S3_ACL_PUBLIC_READ
                ]);
            } catch (\Exception $e) {}
            
            $loadUri = $this->awsConnection->getEndpoint();
            
            $docUrl = $loadUri . "/" . $fullPath . '/' . $file['name'];
            $thumbImage = $loadUri . "/" . $thumbnailpath . '/' . $thumbnaiName;
            $lowResImage = $loadUri . "/" . $lowResPath . '/' . $lowResolutionName;
            $mimeType = $file["type"];
            
            $imageEntity->setCreatedOn(new \DateTime())
                ->setThumbnail($thumbImage)
                ->setImageUrl($docUrl)
                ->setImageName($file['name'])
                ->setLowres($lowResImage)
                ->setImageUid(self::ImageUid())
                ->setIsHidden(FALSE)
                ->setMimeType($mimeType);
            
            // $em->persist($imageEntity);
            
            return $imageEntity;
            
            // }
        }
    }

    /**
     *
     * @param unknown $width            
     */
    private function thumbmailWidthRatio($width)
    {
        $return = [];
        if ($width < self::IMAGE_THUMBNAIL_MINIMUM_WIDTH) {
            $return = [
                "ratio" => 1,
                "width" => $width
            ];
        } else {
            $newWidth = self::IMAGE_THUMBNAIL_MINIMUM_WIDTH;
            $ratio = $newWidth / $width;
            $return = [
                "ratio" => $ratio,
                "width" => $newWidth
            ];
        }
        return $return;
    }

    private function lowresRatio($width)
    {
        $return = [];
        if ($width < self::IMAGE_LOW_RES_MINIMUM_WIDTH) {
            $return = [
                "ratio" => 1,
                "width" => $width
            ];
        } else {
            $newWidth = self::IMAGE_LOW_RES_MINIMUM_WIDTH;
            $ratio = $newWidth / $width;
            $return = [
                "ratio" => $ratio,
                "width" => $newWidth
            ];
        }
        return $return;
    }

    private function createLowerresolution($file)
    {
        $imagine = new Imagine();
        $imageDimensions = getimagesize($file);
        $width = $imageDimensions[0];
        $height = $imageDimensions[1];
        $size = new Box($this->lowresRatio($width)["width"], $this->lowresRatio($width)["ratio"] * $height);
        $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
        return $imagine->open($file)
            ->thumbnail($size, $mode)
            ->get('jpg');
    }

    private function createThumbnail($file)
    {
        $imagine = new Imagine();
        $imageDimensions = getimagesize($file);
        $width = $imageDimensions[0];
        $height = $imageDimensions[1];
        $size = new Box($this->thumbmailWidthRatio($width)["width"], $this->thumbmailWidthRatio($width)["ratio"] * $height);
        $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
        return $imagine->open($file)
            ->thumbnail($size, $mode)
            ->get('jpg');
        // return $url;
    }

    /**
     * This function updates the image in the azure container
     * and removes the old ones
     *
     * @return Image
     */
    protected function updateAzureFile($file, string $oldName = null)
    {
        $newImageEntity = $this->uploadintoAzure($file);
        if ($oldName != NULL) {
            $this->azureConnection->deleteBlob(self::CONTAINER_NAME, $oldName);
        }
        return $newImageEntity;
    }

    public function updateFile($file, string $blobName = NULL)
    {
        switch ($this->specificService) {
            case self::UPLOAD_SERVICE_AZURE:
                $this->updateAzureFile($file, $blobName);
                break;
            case self::UPLOAD_SERVICE_AWS:
                // $thi
                break;
        }
    }

    protected function uploadIntoGcp($file)
    {
        // processes upload into gcp bucket
    }

    public static function ImageUid()
    {
        return uniqid(time());
    }

    /**
     *
     * @param unknown $file            
     * @return \Shop\Entity\Image|string
     */
    public function upload($file)
    {
        switch ($this->specificService) {
            case self::UPLOAD_SERVICE_AWS:
                
                // return $this->uploadIntoAws($file);
                if ($file['type'] == self::PNG_MIME_TYPE || $file['type'] == self::GIF_MIME_TYPE || $file['type'] == self::JPEG_MIME_TYPE || $file['type'] == self::BMP_MIME_TYPE) {
                    // var_dump("KIJU");\
                    return $this->uploadToAws($file);
                } else {
                    return $this->uploadDocumentToAws($file);
                }
                
                break;
            
            case self::UPLOAD_SERVICE_AZURE:
                
                return $this->uploadintoAzure($file);
                break;
            
            case self::UPLOAD_SERVICE_GCP:
                break;
        }
    }

    /**
     *
     * @param \MicrosoftAzure\Storage\Blob\BlobRestProxy $azureConnection            
     */
    public function setAzureConnection($azureConnection)
    {
        $this->azureConnection = $azureConnection;
        return $this;
    }

    /**
     *
     * @param \Aws\S3\S3Client $awsConnection            
     */
    public function setAwsConnection($awsConnection)
    {
        $this->awsConnection = $awsConnection;
        return $this;
    }

    /**
     *
     * @param \Google\Cloud\Storage\StorageClient $gcpConnection            
     */
    public function setGcpConnection($gcpConnection)
    {
        $this->gcpConnection = $gcpConnection;
        return $this;
    }

    /**
     *
     * @param \Doctrine\ORM\EntityManager $entityManager            
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     *
     * @return the $specificService
     */
    public function getSpecificService()
    {
        return $this->specificService;
    }

    /**
     *
     * @param string $specificService            
     */
    public function setSpecificService($specificService)
    {
        $this->specificService = $specificService;
        return $this;
    }
}

