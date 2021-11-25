<?php
namespace Wallet\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use WasabiLib\Ajax\Response;
use Wallet\Service\WalletService;
use Doctrine\ORM\EntityManager;
use WasabiLib\Ajax\InnerHtml;
use WasabiLib\Modal\WasabiModal;
use WasabiLib\Modal\WasabiModalView;
use Wallet\Entity\Wallet;
use Wallet\Form\WalletPasscodeForm;
use WasabiLib\Ajax\GritterMessage;
use Transactions\Service\RaveCardPaymentService;
use GeneralServicer\Service\GeneralService;
use Transactions\Service\TransactionService;
use WasabiLib\Ajax\Redirect;
use Wallet\Form\WalletAddFundsForm;
use Wallet\Form\WalletChangePasscodeForm;
use Laminas\Session\Container;

class WalletController extends AbstractActionController
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var GeneralService
     */
    private $generalService;

    private $renderer;

    /**
     *
     * @var WalletService
     */
    private $walletService;

    public function onDispatch(\Laminas\Mvc\MvcEvent $e)
    {
        $response = parent::onDispatch($e);
        $this->redirectPlugin()->redirectCondition();
        return $response;
    }

    // TODO - Insert your code here
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function indexAction()
    {
        $cont = new Container("bro");
//         echo $cont["five"];
        
        $view = new ViewModel();
        
        return $view;
    }

    public function financiallogsAction()
    {
        $modal = new WasabiModal("standard");
        $response = new Response();
        $modalView = new WasabiModalView("#wasabi", $this->renderer, $modal);
        // $viewModel = new ViewModel(array(
        // "data"=>$data
        // ));
        // $viewModel->setTemplate("");
        // $modal->setContent($viewModel);
        $response->add($modalView);
        return $this->getResponse()->setContent($response);
    }

    // public function passcodecreateAction()
    // {
    // $em = $this->entityManager;
    // $userEntity = $this->identity();
    // $response = new Response();
    // $walletService = $this->walletService;
    // $walletSession = $walletService->getWalletSession();
    // $walletId = $walletSession->walletId;
    // /**
    // *
    // * @var WalletPasscodeForm $walletPasscodeForm
    // */
    // $walletPasscodeForm = $this->walletPasscodeForm;
    // $walletPasscodeForm->setAttributes(array(
    // "id" => "simpleForm",
    // "class" => "form-horizontal form-label-left ajax_element",
    // "data-ajax-loader" => "passcodeLoader",
    // "action" => $this->url()
    // ->fromRoute("wallet/default", array(
    // "action" => "passcodecreate"
    // ))
    // ));
    
    // $modal = new WasabiModal("standard", "Wallet Passcode");
    // $gritter = new GritterMessage();
    // $request = $this->getRequest();
    // if ($request->isPost()) {
    // $post = $this->params()->fromPost();
    // $walletPasscodeForm->setData($post);
    
    // if ($walletPasscodeForm->isValid()) {
    // $data = $post["walletPasscodeFieldset"]["passcode"];
    // $walletPasscodeEntity = new WalletPasscode();
    
    // $encriptedPassword = \CsnUser\Service\UserService::encryptPassword($data);
    
    // $walletPasscodeEntity->setPasscode($encriptedPassword)->setWallet($em->find("Wallet\Entity\Wallet", $walletId));
    
    // try {
    // $em->persist($walletPasscodeEntity);
    // $em->flush();
    // $triggerParam = array(
    // "wallet" => $walletId,
    // "user" => $userEntity->getId()
    // );
    // /**
    // * This sends an email , SMS notification
    // */
    
    // $this->getEventManager()->trigger(TriggerService::TRIGGER_WALLET_PASSCODE_CREATED, $this, $triggerParam);
    // $gritter->setTitle("Passcode Created");
    // $gritter->setText("Passcode Successfully Created");
    // $gritter->setType(GritterMessage::TYPE_SUCCESS);
    // $gritter->setSticky(TRUE);
    // $redirect = new Redirect($this->url()->fromRoute("wallet/default", array(
    // "action" => "overview"
    // )));
    // $this->flashMessenger()->addSuccessMessage("Passcode Successfully Created");
    // $response->add($redirect);
    
    // $response->add($gritter);
    // } catch (\Exception $e) {
    // $gritter->setTitle("Hydration Error");
    // $gritter->setText("System could not create passcode at this moment, please try again later");
    // $gritter->setType(GritterMessage::TYPE_ERROR);
    // $gritter->setSticky(TRUE);
    
    // $response->add($gritter);
    // }
    // // Process passcode
    // // Encrypt it and save into the database
    // } else {
    // $messages = ErrorService::errorFromForm($walletPasscodeForm->getMessages());
    
    // //
    // $gritter->setTitle("Validation Error");
    // $gritter->setText($messages);
    // $gritter->setType(GritterMessage::TYPE_ERROR);
    // $gritter->setSticky(TRUE);
    
    // $response->add($gritter);
    // }
    // } else {
    // $viewModel = new ViewModel(array(
    // "form" => $walletPasscodeForm
    // ));
    
    // $viewModel->setTemplate("wallet_passcode_modal_form_snippet");
    // $modal->setContent($viewModel);
    
    // $modalView = new WasabiModalView("#wasabi", $this->renderer, $modal);
    // // var_dump("ser");
    // $response->add($modalView);
    // }
    // return $this->getResponse()->setContent($response);
    // }
    
    // public function changepasscodeAction()
    // {
    // $response = new Response();
    // $gritter = new GritterMessage();
    
    // $walletChangePasscodeForm = $this->walletChangePasscodeForm;
    // $request = $this->getRequest();
    // if($request->isPost()){
    // $post = $request->getPost();
    // $walletChangePasscodeForm->setData($post);
    // if($walletChangePasscodeForm->isValid()){
    // try {
    // // $cleanPassword =
    // } catch (\Exception $e) {
    // $gritter->setTitle("Error");
    // $gritter->setText("Error updating wallet Passcode");
    // $gritter->setType(GritterMessage::TYPE_ERROR);
    // $gritter->setSticky(TRUE);
    
    // $response->add($gritter);
    // }
    // }
    // }else{
    // $viewModel = new ViewModel(array(
    // "form"=>$walletChangePasscodeForm
    // ));
    // $viewModel->setTemplate("wallet_change_passcode_modal_form_snippet");
    // $modal = new WasabiModal("standard", "Change Wallet PassCode");
    
    // $modal->setContent($viewModel);
    // $modalView = new WasabiModalView("#wasabi", $this->renderer, $modal);
    // $response->add($modalView);
    // }
    // return $this->getResponse()->setContent($response);
    // }
    
    // public function overviewAction()
    // {
    // $em = $this->entityManager;
    // $userEntity = $this->identity();
    
    // /**
    // *
    // * @var \Wallet\Service\WalletService $walletService
    // */
    // $walletService = $this->walletService;
    // $walletSession = $walletService->getWalletSession();
    // $walletEntity = $em->getRepository("Wallet\Entity\Wallet")->findOneBy(array(
    // "user" => $userEntity->getId()
    // ));
    // $walletSession->walletId = $walletEntity->getId();
    // /**
    // *
    // * @var Wallet $walletEntity
    // */
    // // $walletEntity = $em->getRepository("Wallet\Entity\Wallet")->findOneBy(array(
    // // "user" => $userEntity->getId()
    // // ));
    // $walletPasscode = NULL;
    // if ($walletEntity != NULL) {
    // $walletPasscode = $walletEntity->getPasscode();
    // }
    
    // $walletBalance = $walletService->getAvaialableBalance($this->identity()
    // ->getId());
    
    // $lastWithdrawal = $walletService->getLastWithrawal($this->identity()
    // ->getId());
    
    // $bookBalance = $walletService->getBookBalance();
    // // $this->walletService->getTransation();
    // $viewModel = new ViewModel(array(
    // "balance" => $walletBalance,
    // "lastwithdrawal" => $lastWithdrawal,
    // "bookBalance" => $bookBalance,
    // "passcode" => $walletPasscode
    // // "gen"=>$this->generalService
    // ));
    // return $viewModel;
    // }
    
    // /**
    // *
    // * @return mixed
    // */
    // public function transactionajaxAction()
    // {
    // $em = $this->entityManager;
    
    // $userEntity = $this->identity();
    // /**
    // * gets a list of transaction attached to this
    // */
    // $transactions = $em->getRepository("Wallet\Entity\Wallet")->findLast20Transaction($userEntity->getId());
    // // var_dump("HYYY");
    // $viewModel = new ViewModel(array(
    // "transactions" => $transactions
    // ));
    // $viewModel->setTemplate("wallet_transactions_list_snippet");
    // $html = $this->renderer->render($viewModel);
    // // var_dump($html);
    
    // return $this->getResponse()->setContent($html);
    // }
    
    // public function confirmtransactionAction()
    // {
    // $response = new Response();
    
    // return $this->getResponse()->setContent($response);
    // }
    
    // /**
    // * This function withdarws funds from the wallet
    // * Initiatistes a withdrawal initent on Rave
    // *
    // * @return mixed
    // */
    // public function withdrawfundsmodalAction()
    // {
    // $em = $this->entityManager;
    // $response = new Response();
    // /**
    // *
    // * @var User $user
    // */
    // $user = $this->identity();
    // /**
    // *
    // * @var WalletTransactionForm $walletTransactionForm
    // */
    // $walletTransactionForm = $this->walletTransactionForm;
    // $walletTransactionForm->setAttributes(array(
    // "id" => "simpleForm",
    // "class" => "form-horizontal form-label-left ajax_element",
    // "data-ajax-loader" => "registerNewLoader",
    // "action" => $this->url()
    // ->fromRoute("wallet/default", array(
    // "action" => "withdrawfundsmodal"
    // ))
    // ));
    
    // $request = $this->getRequest();
    // $gritter = new GritterMessage();
    // $walletService = $this->walletService;
    // $walletSession = $walletService->getWalletSession();
    
    // /**
    // *
    // * @var Wallet $walletEntity
    // */
    // $walletEntity = $em->getRepository("Wallet\Entity\Wallet")->findOneBy(array(
    // "user" => $user->getId()
    // ));
    // $amount = $walletTransactionForm->get("walletTransactionFieldset")->get("amount");
    // $amountValue = $walletEntity->getBalance();
    // $deductible = intval($amountValue) - TransactionService::IMAPP_TRANSFER_FEE;
    // if ($deductible < 0) {
    // $deductible = 0;
    // }
    // $amount->setValue($deductible);
    
    // $url = $this->url()->fromRoute("wallet/default", array(
    // "action" => "passcodecreate"
    // ));
    // $link = "<a id='btn2' data-href='{$url}' class='ajax_element'>click this link</a>";
    // if ($walletEntity->getPasscode() == NULL) {
    // $gritter->setTitle("Empty Passcode ");
    // $gritter->setText("Please {$link} to create your passcode");
    // $gritter->setType(GritterMessage::TYPE_ALERT);
    // $gritter->setSticky(TRUE);
    
    // $response->add($gritter);
    // } else {
    // if ($request->isPost()) {
    // $post = $this->params()->fromPost();
    
    // $walletTransactionForm->setData($post);
    // // try {
    // $passwordStatus = \CsnUser\Service\UserService::verifyPasscode($walletEntity, $post["walletTransactionFieldset"]["passcode"]);
    
    // if ($passwordStatus) {
    
    // if ($walletTransactionForm->isValid()) {
    // $data = $walletTransactionForm->getData();
    // $amount = CurrencyService::cleanInputValueStatic($data->getAmount());
    
    // $walletSession->walletId = $walletEntity->getId();
    // $cleanAmount = (float) $amount;
    // if ((($cleanAmount + TransactionService::IMAPP_TRANSFER_FEE) < $walletEntity->getBalance())) {
    // $raveCardPaymentService = $this->raveCardPaymentService;
    // $generalService = $this->generalService;
    // $brokerId = $generalService->getCentralBroker();
    
    // /**
    // *
    // * @var InsuranceBrokerRegistered $brokerEntity
    // */
    // $brokerEntity = $em->find("Users\Entity\InsuranceBrokerRegistered", $brokerId);
    
    // // inititiate trANSFER TO BROKER ACCOUNT ON RECORD
    // // make
    // $raveCardPaymentService->setTransferAcc($brokerEntity->getBrokerBankAccount()
    // ->getBankAccountNo())
    // ->setTransferAmount($cleanAmount)
    // ->setTransferBank($brokerEntity->getBrokerBankAccount()
    // ->getBankName()
    // ->getMoneyWaveCode())
    // ->setTransferCurrency(CurrencyService::NIGERIA_NAIRA_CODE);
    // try {
    // $raveCardPaymentService->initiateBrokerTransfer();
    
    // $gritter->setTitle("Transfer Initated");
    // $gritter->setText("Successfully initiated Transfer");
    // $gritter->setType(GritterMessage::TYPE_SUCCESS);
    // $gritter->setSticky(TRUE);
    
    // $response->add($gritter);
    
    // $redirect = new Redirect($this->url()->fromRoute("wallet/default", array(
    // "action" => "overview"
    // )));
    // $response->add($redirect);
    // } catch (\Exception $e) {
    // $gritter->setTitle("Tranfer Error");
    // $response->add($gritter);
    // }
    // } else {
    // // gritter Insufficient funds
    // $gritter->setTitle("Insufficient Balance");
    // $gritter->setText("Your Balance is not sifficient for this transaction");
    // $gritter->setType(GritterMessage::TYPE_ERROR);
    
    // $gritter->setSticky(true);
    
    // $response->add($gritter);
    // }
    // }
    // } else {
    
    // $gritter->setTitle("Passcode Error");
    // $gritter->setText("Your Passcode is incorrect");
    // $gritter->setType(GritterMessage::TYPE_ERROR);
    // $gritter->setSticky(TRUE);
    
    // $response->add($gritter);
    // }
    // } else {
    // $modal = new WasabiModal("standard", "Withraw Funds");
    // $viewModel = new ViewModel(array(
    // "form" => $walletTransactionForm
    // ));
    // $viewModel->setTemplate("wallet_transaction_modal_form_snippet");
    // $modal->setContent($viewModel);
    // $modalView = new WasabiModalView("#wasabi", $this->renderer, $modal);
    // $response->add($modalView);
    // }
    // }
    
    // return $this->getResponse()->setContent($response);
    // }
    
    // public function addfundsmodalAction()
    // {
    // $response = new Response();
    // $walletAddFundForm = $this->walletAddFundForm;
    
    // $request = $this->getRequest();
    // if ($request->isPost()) {
    // $post = $this->params()->fromPost();
    // $walletTransactionForm->setData($post);
    // if ($walletTransactionForm->isValid()) {}
    // }else{
    // $modal = new WasabiModal("standard", "Add Funds");
    // $viewModel = new ViewModel(array(
    // "form" => $walletAddFundForm
    // ));
    // $viewModel->setTemplate("wallet_add_fund_modal_form_snippet");
    // $modal->setContent($viewModel);
    // $modalView = new WasabiModalView("#wasabi", $this->renderer, $modal);
    // $response->add($modalView);
    // }
    // return $this->getResponse()->setContent($response);
    // }
    public function fulltransactionAction()
    {
      
        $view = new ViewModel();
        return $view;
    }

    public function walletpinAction()
    {
        $response = new Response();
        return $this->getResponse()->setContent($response);
    }

    /**
     *
     * @param mixed $entityManager            
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     *
     * @param mixed $generalService            
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return $this;
    }

    /**
     *
     * @param mixed $walletService            
     */
    public function setWalletService($walletService)
    {
        $this->walletService = $walletService;
        return $this;
    }

    /**
     *
     * @return mixed
     */
    public function getRenderer()
    {
        return $this->renderer;
    }

    /**
     *
     * @param mixed $renderer            
     */
    public function setRenderer($renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }

    // public function
    
    /**
     *
     * @param mixed $walletTransactionForm            
     */
    public function setWalletTransactionForm($walletTransactionForm)
    {
        $this->walletTransactionForm = $walletTransactionForm;
        return $this;
    }

    /**
     *
     * @param mixed $walletPasscodeForm            
     */
    public function setWalletPasscodeForm($walletPasscodeForm)
    {
        $this->walletPasscodeForm = $walletPasscodeForm;
        return $this;
    }

    /**
     *
     * @param mixed $raveCardPaymentService            
     */
    public function setRaveCardPaymentService($raveCardPaymentService)
    {
        $this->raveCardPaymentService = $raveCardPaymentService;
        return $this;
    }

    /**
     *
     * @param \Wallet\Form\WalletAddFundsForm $walletAddFundForm            
     */
    public function setWalletAddFundForm($walletAddFundForm)
    {
        $this->walletAddFundForm = $walletAddFundForm;
        return $this;
    }

    /**
     *
     * @param \Wallet\Form\WalletChangePasscodeForm $walletChangePasscodeForm            
     */
    public function setWalletChangePasscodeForm($walletChangePasscodeForm)
    {
        $this->walletChangePasscodeForm = $walletChangePasscodeForm;
        return $this;
    }
}

