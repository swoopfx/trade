<?php
namespace Bbmin\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

/**
 *
 * @author otaba
 *        
 */
class SupportController extends AbstractActionController
{

    public function indexAction(){
        
    }
    
    public function openTicketAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }
}

