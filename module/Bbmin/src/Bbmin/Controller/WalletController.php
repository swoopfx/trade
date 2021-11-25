<?php
namespace Bbmin\Controller;

use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Paginator\Paginator;
use Laminas\View\Model\ViewModel;
use CsnUser\Entity\User;

/**
 *
 * @author otaba
 *        
 */
class WalletController extends AbstractActionController
{
    /**
     * @var EntityManager
     */
    private $entityManager;




    /**
     * @var Paginator
     */
    private $walletPaginator;


    public function walletsAction(){
        $viewModel = new ViewModel(array(
            "wallets"=>$this->walletPaginator
        ));
        return $viewModel;
    }

    public function userWalletAction(){
        $em = $this->entityManager;
//        $userUid = $this->params()->fromRoute("id", NULL);
//        /**
//         *
//         * @var User $userEntity
//         */
//        $userEntity = $em->getRepository("CsnUser\Entity\User")->findOneBy(array(
//            "userUid"=>$userUid
//        ));
//        if($userEntity != NULL){
//            $walletEntity = $userEntity->getWallet();
//            $viewModel = new ViewModel(array(
//                "wallet"=>$walletEntity
//            ));
//            return $viewModel;
//        }else{
//            return $this->redirect()->toRoute("bbminwallet/default", array("action"=>"wallets"));
//        }
       
//         $em->getRepository("Wallet\Entity\Wallet")->findOneBy(array(
//             "user"=>
//         ));
        $viewModel = new ViewModel();
        return $viewModel;
      
    }
    
    public function activityAction(){
        $viewMode = new ViewModel();
        return $viewMode;
    }
    
    
    public function reportAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * @param Paginator $walletPaginator
     * @return WalletController
     */
    public function setWalletPaginator($walletPaginator)
    {
        $this->walletPaginator = $walletPaginator;
        return $this;
    }


}

