<?php
namespace General\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

/**
 *
 * @author mac
 *        
 */
class GeneralController extends AbstractActionController
{

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    public function indexAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
    public function adminordershippingAction(){
        $id = $this->params()->fromRoute("id", NULL);
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
    public function adminorderinvoiceAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }
}

