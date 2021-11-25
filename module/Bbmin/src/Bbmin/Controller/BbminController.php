<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Bbmin for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Bbmin\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\MvcEvent;
use Laminas\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Shop\Entity\Repository\OrderRepository;
use Laminas\View\Model\JsonModel;
use Support\Entity\Repository\SupportRepository;
use Training\Entity\Training;
use CsnUser\Entity\User;
use CsnUser\Service\UserService;
use Training\Service\TrainingService;

class BbminController extends AbstractActionController
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;
    
    /**
     * 
     * @var TrainingService
     */
    private $trainingService;

    public function onDispatch(MvcEvent $e)
    {
        $response = parent::onDispatch($e);
        $this->redirectPlugin()->redirectToLogout();
        $this->redirectPlugin()->adminRedirection();
        return $response;
    }

    public function indexAction()
    {
        $em = $this->entityManager;
        $top30UnsettledOrder = $em->getRepository("Shop\Entity\CartOrders")->findBy(array(
            "isClosed" => FALSE
        ), array(
            "id" => "DESC"
        ), 30);
        $recentTraining = $this->trainingService->getMostRecentTraining();

        
        $recentUsers = $em->getRepository(User::class)->findBy([
            "role"=>UserService::USER_ROLE_PROFILED,
            "role"=>UserService::USER_ROLE_GUARATEED,
            "role"=>UserService::USER_ROLE_MEMBER
        ],[],20);
        
       
        $viewModel = new ViewModel(array(
            "unsettledOrder"=>$top30UnsettledOrder,
            "recentTraining"=>$recentTraining,
            "recentUsers"=>$recentUsers
        ));
        return $viewModel;
    }
    
    public function dashboardAnalyticsActions(){
        $em = $this->entityManager;
        // get information
        // gets Statistics from cronjob hydrated table
        // 
        $jsonModel = new JsonModel(array(
            "dailyUser"=>0,
            "dailyEnrolment"=>0,
            "dailyOrder"=>0,
            "dailyReturnedUser"=>0,
            "dailyPageViewed"=>0,
            
        ));
        return $jsonModel;
    }

    public function orderunsettledcountAction()
    {
        $em = $this->entityManager;
        /**
         *
         * @var OrderRepository $orderRepository
         */
        $orderRepository = $em->getRepository("Shop\Entity\CartOrders");
        $count = $orderRepository->count();
        
        // $count = 30;
        $json = new JsonModel(array(
            "count" => $count
        ));
        return $json;
    }

    public function supportopenticketcountAction()
    {
        $em = $this->entityManager;
        /**
         *
         * @var SupportRepository $supportRepository
         */
        $supportRepository = $em->getRepository("Support\Entity\Support");
        $count = $supportRepository->count();
        $jsonModel = new JsonModel(array(
            "count" => $count
        ));
        return $jsonModel;
    }
    
    
    public function totalcustomerAction(){
        $em = $this->entityManager;
        $customerRepository = $em->getRepository("CsnUser\Entity\User");
        $customerCount = $customerRepository->count();
        $jsonModel = new JsonModel(array(
            "count"=>$customerCount
        ));
        return $jsonModel;
    }

    /**
     * Gets the present months total number of sales
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function monthlysaleAction()
    {
        $jsonModel = new JsonModel();
        return $jsonModel;
    }

    /**
     * Get this months toal number of customer regutered
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function monthlycustomerAction()
    {
        $jsonModel = new JsonModel();
        return $jsonModel;
    }

    public function dashboardstatisticsAction()
    {
        $em = $this->entityManager;
        /**
         *
         * @var SupportRepository $supportRepository
         */
        $supportRepository = $em->getRepository("Support\Entity\Support");
        /**
         *
         * @var OrderRepository $orderRepository
         */
        $orderRepository = $em->getRepository("Shop\Entity\Order");
        $orderCount = $orderRepository->count();
        $supportCount = $supportRepository->count();
        $sales = "0";
        $customer = "0";
        $jsonModel = new JsonModel(array(
            "order" => $orderCount,
            "support" => $supportCount,
            "sale" => $sales,
            "customer" => $customer
        ));
        return $jsonModel;
    }

    /**
     *
     * @param field_type $entityManager            
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }
    /**
     * @param field_type $trainingService
     */
    public function setTrainingService($trainingService)
    {
        $this->trainingService = $trainingService;
        return $this;
    }

}
