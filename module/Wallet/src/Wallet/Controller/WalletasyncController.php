<?php
namespace Wallet\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Wallet\Entity\Credit;
use CsnUser\Entity\User;
use Wallet\Entity\ReferalUnits;
use Doctrine\ORM\EntityManager;
use Transaction\Entity\TransactionBonus;
use Wallet\Entity\Wallet;
use Wallet\Service\WalletService;
use General\Service\GeneralService;
use Transaction\Service\TransactionService;
use Wallet\Service\ReferalService;
use Wallet\Service\CreditService;

/**
 *
 * @author otaba
 *        
 */
class WalletasyncController extends AbstractActionController
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    
    /**
     * 
     * @var CreditService
     */
    private $creditService;

    /**
     * 
     * @var ReferalService
     */
    private $referalService;

    /**
     * 
     * @var WalletService
     */
    private $walletService;

    /**
     * 
     * @var TransactionService
     */
    private $transactionService;

    /**
     * 
     * @var GeneralService
     */
    private $generalService;

    /**
     */
    public function __construct()
    {}

    public function walletbalanceAction(): JsonModel
    {
        $jsonModel = new JsonModel();
//         var_dump("hey");
        /**
         *
         * @var User $user
         */
        $user = $this->identity();
        /**
         *
         * @var Wallet $wallet
         */
        $balance = 0 ;
        
        $wallet = $user->getWallet();
        if($wallet != null){
            $balance = $wallet->getBalance();
        }
        $jsonModel->setVariable('data', $balance);
        return $jsonModel;
    }

    public function creditbonusAction()
    {
        $response = $this->getResponse();
        /**
         *
         * @var User $user
         */
        $user = $this->identity();
        /**
         *
         * @var Credit $credit
         */
        $credit = $user->getCredit();
        $bonus = ($credit == NULL ? 0 : $credit->getCreditBonus());
        $response->setStatusCode(200);
        $json = new JsonModel([
            "credit" => $bonus
        ]);
        return $json;
    }

    public function referalbonusAction()
    {
        $response = $this->getResponse();
        /**
         *
         * @var User $user
         */
        $user = $this->identity();
        
        /**
         *
         * @var ReferalUnits $referal
         */
        $referal = $user->getReferalUnit();
        $response->setStatusCode(200);
        $units = ($referal == NULL ? 0 : $referal->getRunits());
        $jsonModel = new JsonModel([
            "referal" => $units
        ]);
    }

    public function transactionbonusAction()
    {
        $response = $this->getResponse();
        /**
         *
         * @var User $user
         */
        $user = $this->identity();
        /**
         *
         * @var TransactionBonus $transactionBonus
         */
        $transactionBonus = $user->getTransactionBonus();
        $bonus = ($transactionBonus == NULL ? 0 : $transactionBonus->getBonus());
        $jsonModel = new JsonModel([
            "bonus" => $bonus
        ]);
        return $jsonModel;
    }

    public function aggregaterevenueAction()
    {}
    /**
     * @return the $entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @return the $creditService
     */
    public function getCreditService()
    {
        return $this->creditService;
    }

    /**
     * @return the $referalService
     */
    public function getReferalService()
    {
        return $this->referalService;
    }

    /**
     * @return the $walletService
     */
    public function getWalletService()
    {
        return $this->walletService;
    }

    /**
     * @return the $transactionService
     */
    public function getTransactionService()
    {
        return $this->transactionService;
    }

    /**
     * @return the $generalService
     */
    public function getGeneralService()
    {
        return $this->generalService;
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * @param \Wallet\Service\CreditService $creditService
     */
    public function setCreditService($creditService)
    {
        $this->creditService = $creditService;
        return $this;
    }

    /**
     * @param \Wallet\Service\ReferalService $referalService
     */
    public function setReferalService($referalService)
    {
        $this->referalService = $referalService;
        return $this;
    }

    /**
     * @param \Wallet\Service\WalletService $walletService
     */
    public function setWalletService($walletService)
    {
        $this->walletService = $walletService;
        return $this;
    }

    /**
     * @param \Transaction\Service\TransactionService $transactionService
     */
    public function setTransactionService($transactionService)
    {
        $this->transactionService = $transactionService;
        return $this;
    }

    /**
     * @param \General\Service\GeneralService $generalService
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return $this;
    }

}

