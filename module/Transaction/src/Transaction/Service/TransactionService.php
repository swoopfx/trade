<?php
namespace Transaction\Service;

use Doctrine\ORM\EntityManager;
use Laminas\Authentication\AuthenticationService;
use General\Service\GeneralService;
use Transaction\Entity\TransactionBonus;
use Transaction\Entity\Invoice;
use General\Service\CentralUnitOfWorkInterface;
use Transaction\Entity\Transaction;
use Transaction\Entity\TransactionStatus;
use Transaction\Entity\PaymentMethod;
use Settings\Entity\CheckoutPaymentMethod;

/**
 *
 * @author otaba
 *        
 */
class TransactionService implements CentralUnitOfWorkInterface
{

    const TRANSACTION_STATUS_SUCCESS = 10;

    const TRANSACTION_STATUS_FAILED = 100;

    const TRANSACTION_STATUS_PENDING = 1000;

    const PAYMENT_METHOD_WALLET = 200;

    const PAYMENT_METHOD_BANK = 20;

    const PAYMENT_METHOD_CASH = 30;

    const PAYMENT_METHOD_CARD = 10;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var AuthenticationService
     */
    private $auth;

    /**
     *
     * @var string
     */
    private $userId;

    /**
     *
     * @var GeneralService
     */
    private $generalService;

    private $unitOfWork;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public static function transactionUid()
    {
        return uniqid("transact");
    }
    
    public static function notifyPaymentUid(){
        return uniqid("notpay");
    }

    /**
     *
     * @param string $userId            
     * @return \Transaction\Entity\the|number
     */
    public function getTransactionBonus(string $userId)
    {
        $em = $this->entityManager;
        /**
         *
         * @var TransactionBonus $transactionBonusEntity
         */
        $transactionBonusEntity = $em->getRepository("Transaction\Entity\TransactionBonus")->findOneBy(array(
            "user" => $userId
        ));
        if ($transactionBonusEntity != NULL) {
            return $transactionBonusEntity->getBonus();
        } else {
            return 0;
        }
    }

    public function successfullTransaction($data)
    {
        $em = $this->entityManager;
        $transactionEntity = new Transaction();
        $transactionEntity->setCreatedOn(new \DateTime())
            ->setInvoice($data['invoice'])
            ->setTransactionStatus($em->find(TransactionStatus::class, TransactionService::TRANSACTION_STATUS_SUCCESS))
            ->setTransactionUid($this->transactionUid())
            ->setTransactionType($em->find(CheckoutPaymentMethod::class, $data["paymentMethod"]));
        $em->persist($transactionEntity);
    }

    public function makeInvoice()
    {
        $invoiceEntity = new Invoice();
        return $this;
    }

    /**
     *
     * @return the $entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     *
     * @return the $auth
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     *
     * @return the $userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     *
     * @return the $generalService
     */
    public function getGeneralService()
    {
        return $this->generalService;
    }

    /**
     *
     * @param \Doctrine\ORM\EntityManager $entityManager            
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     *
     * @param \Laminas\Authentication\AuthenticationService $auth            
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
        return $this;
    }

    /**
     *
     * @param string $userId            
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     *
     * @param \General\Service\GeneralService $generalService            
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \General\Service\CentralUnitOfWorkInterface::unitOfWork()
     */
    public function unitOfWork()
    {
        return $this->unitOfWork;
    }
}

