<?php
namespace Training\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use Training\Service\TrainingService;

/**
 *
 * @author otaba
 *        
 */
class TrainingStatusHelper extends AbstractHelper
{

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function __invoke($status)
    {
        $id = $status->getId();
        switch ($id){
            case TrainingService::TRAINING_STATUS_CANCELLED:
                return "<span class='square-8 bg-danger mg-r-5 rounded-circle'></span> CANCELLED";
                break;
                
            case TrainingService::TRAINING_STATUS_COMPLETED:
                return "<span class='square-8 bg-success mg-r-5 rounded-circle'></span> COMPLETED";
                break;
                
            case TrainingService::TRAINING_STATUS_IN_PROGRESS:
                return "<span class='square-8 bg-warning mg-r-5 rounded-circle'></span> PROGRESS";
                break;
        }
    }
}

