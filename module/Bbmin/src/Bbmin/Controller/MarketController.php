<?php
namespace Bbmin\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

/**
 *
 * @author otaba
 *        
 */
class MarketController extends AbstractActionController
{

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    public function eventAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
    public function bonusAction(){
        $viewmodel = new ViewModel();
        return $viewmodel;
    }
    
    
    public function couponsAction(){
        $viewmodel = new ViewModel();
        return $viewmodel;
    }
    
    
    public function activityAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }
}

