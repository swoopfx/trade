<?php
namespace Bbmin\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

/**
 *
 * @author otaba
 *        
 */
class SystemController extends AbstractActionController
{

    
    
    /**
     */
    public function __construct()
    {
        
       
    }
    
    
    public function settingsAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
    
    public function maintenanceAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }
}

