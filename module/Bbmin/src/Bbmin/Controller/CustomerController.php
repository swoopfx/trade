<?php
namespace Bbmin\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Bbmin\Paginator\CustomerAdapter;
use CsnUser\Entity\User;
use Doctrine\ORM\EntityManager;
use Laminas\View\Model\JsonModel;

/**
 *
 * @author otaba
 *        
 */
class CustomerController extends AbstractActionController
{
    /**
     * 
     * @var EntityManager
     */
    private $entityManager;

   
    /**
     * 
     * @var CustomerAdapter
     */
    private $customerPaginator;

    
    /**
     * 
     * @var unknown
     */
    private $countryPaginator;

    /**
     * @param mixed $countryPaginator
     * @return CustomerController
     */
    public function setCountryPaginator($countryPaginator)
    {
        $this->countryPaginator = $countryPaginator;
        return $this;
    }
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    public function allAction(){

//        var_dump($this->countryPaginator);
        $viewmodle = new ViewModel(array(
            "customers"=>$this->customerPaginator,
//             "counties"=>$this->countryPaginator
        ));
        return $viewmodle;
    }
    
//     public function viewAction(){
//         $em = $this->entityManager;
//         $customerUid = $this->params()->fromRoute("id", NULL);
//         if($customerUid == NULL){
//             return $this->redirect()->toRoute("bbmincustomer/default", array("action"=>"all"));
//         }else{
//             var_dump($em);
// //             $customerEntity = $em->getRepository(User::class)->findOneBy(array(
// //                 "id"=>1
// //             ));
// //             var_dump($customerEntity);
// //             $viewModel = new ViewModel(array(
// //                 "customer"=>$customerEntity
// //             ));
//             return $viewModel;
//         }
       
//     }
    
   
    
    
    public function manageAction(){
        
        $em = $this->entityManager;
        $customerUid = $this->params()->fromRoute("id", NULL);
        if($customerUid == NULL){
            return $this->redirect()->toRoute("bbmincustomer/default", array("action"=>"all"));
        }else{
//           
            $customerEntity = $em->getRepository(User::class)->findOneBy(array(
                "userUid"=>$customerUid
            ));
            $viewModel = new ViewModel(array(
                "customer"=>$customerEntity
            ));
            return $viewModel;
        }
    }

    public function disableAction(){
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        if($request->isPost()){
            $em = $this->entityManager;
        
            $post = $request->getPost();
            $userEntity = $em->find(User::class, $post["userId"]);
            $response->setStatusCode(202);
        }
        return $jsonModel;
    }
    
    
    
    public function blacklistAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
    public function statisticsAction(){
        $viewmodel = new ViewModel();
        return $viewmodel;
    }
    /**
     * @param field_type $customerPaginator
     */
    public function setCustomerPaginator($customerPaginator)
    {
        $this->customerPaginator = $customerPaginator;
        return $this;
    }
    /**
     * @param field_type $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }


}

