<?php
namespace Bbmin\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;

/**
 *
 * @author ezekiel
 *        
 */
class ShopboardController extends AbstractActionController
{
    
    private $entityManager;
    
    private $generalService;
    
    private $shopboarService;

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    /**
     * Calculates the number of sales from sunday
     * @return \Laminas\View\Model\JsonModel
     */
    public function thisweeksalescountAction(){
        $jsonModel = new JsonModel();
        return $jsonModel;
    }
    
    /**
     * Calculates the number of unprocessed order
     * @return \Laminas\View\Model\JsonModel
     */
    public function unprocessedordercountAction(){
        $jsonModel = new JsonModel();
        return $jsonModel;
    }
   
    
    public function averagesalesordercountAction(){
        $jsonModel = new JsonModel();
        
        return $jsonModel;
    }
    
    /**
     * 
     * @return \Laminas\View\Model\JsonModel
     */
    public function totalsalesordercountAction(){
        $jsonModel = new JsonModel();
        return $jsonModel;
    }
    
    public function newvisitorcountAction(){
        
    }
    
    
    public function topproductAction(){
        
    }
    
    public function ordersAction(){
        
    }
    
    
    public function campaignAction(){
        
    }
}

