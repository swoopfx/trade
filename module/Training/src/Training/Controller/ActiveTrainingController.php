<?php
namespace Training\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

/**
 *
 * @author otaba
 *        
 */
class ActiveTrainingController extends AbstractActionController
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
}

