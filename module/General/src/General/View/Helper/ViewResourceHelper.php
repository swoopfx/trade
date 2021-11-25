<?php
namespace General\View\Helper;

use Laminas\View\Helper\AbstractHelper;

/**
 *
 * @author mac
 *        
 */
class ViewResourceHelper extends AbstractHelper
{

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function __invoke($data)
    {
        if ($data == "application/pdf") {
            return "<i class='fa fa-file-pdf-o'></i>";
        } else if ($data == "image/jpeg" || $data == "image/png") {
            return "<i class='fa fa-file-image-o'></i>";
        } else if ($data == "application/vnd.ms-excel") {
            return "<i class='fa fa-file-excel-o'></i>";
        } else if ($data == "application/msword") {
            return "<i class='fa fa-file-word-o'></i>";
        } else if ($data == "application/zip") {
            return "<i class='fa fa-file-zip-o'></i>";
        } else if ($data == "audio/mpeg") {
            return "<i class='fa fa-file-sound-o'></i>";
        } else {
            return "<i class='fa fa-file'></i>";
        }
    }
}

