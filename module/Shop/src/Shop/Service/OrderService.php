<?php
namespace Shop\Service;

use Shop\Paginator\OrderUnsettledAdapter;
use Doctrine\ORM\EntityManager;
use Shop\Entity\CartOrders;
use Shop\Entity\Cart;
use Transaction\Entity\Invoice;
use Shop\Entity\OrderStatus;
use General\Service\GeneralService;
use Shop\Entity\BankCheckout;
use General\Service\CentralUnitOfWorkInterface;
use Shop\Entity\CashCheckout;
use CsnUser\Entity\User;
use Wallet\Entity\Wallet;
use Transaction\Entity\Transaction;
use Wallet\Entity\WalletActivity;
use Wallet\Entity\WalletCartTransaction;
use Transaction\Service\TransactionService;
use Settings\Entity\CheckoutPaymentMethod;
use Transaction\Entity\TransactionStatus;
use Transaction\Service\InvoiceService;
use Transaction\Entity\InvoiceStatus;
use Shop\Entity\WalletCheckout;
use Shop\Entity\Checkout;
use Wallet\Entity\WalletOrderTransaction;

/**
 *
 * @author otaba
 *        
 */
class OrderService implements CentralUnitOfWorkInterface
{

    const ORDER_STATUS_INITIATED = 10;

    const ORDER_STATUS_EXPIRED = 14;

    const ORDER_STATUS_PROCESSED = 15;

    const ORDER_STATUS_VOIDED = 16;

    const ORDER_STATUS_REFUNDED = 120;

    const ORDER_STATUS_REVERSED = 130;

    const ORDER_STATUS_CHARGEBACK = 140;

    const ORDER_STATUS_PENDING = 150;

    const ORDER_STATUS_SHIPPED = 300;

    const ORDER_STATUS_DENIED = 800;

    const ORDER_STATUS_PROCESSING = 100;

    const ORDER_STATUS_CANCELED = 700;

    // CONST ORDER_STATUS_EVALUATING = 100;
    const ORDER_STATUS_DELIVERED = 200;

    const ORDER_STATUS_WAITING_PICKUP = 300;

    /**
     *
     * @var OrderUnsettledAdapter
     */
    private $orderPaginator;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var Cart
     */
    private $cartEntity;

    /**
     *
     * @var Invoice
     */
    private $invoiceEntity;

    /**
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     *
     * @var CartOrders
     */
    private $cartOrderEntity;

    /**
     *
     * @var unknown
     */
    private $unitOfWork;

    /**
     *
     * @var CartService
     */
    private $cartService;

    /**
     *
     * @var DeliveryCalculatorService
     */
    private $deliverycalculatorService;

    private $deliveryType;

    private $checkoutPaymentMethod;

    private $useWallet;

    private $hasDiscount = false;

    /**
     *
     * @var TransactionService
     */
    private $transactionService;
    
    
    private $walletOrderTransactionEnity;

    /**
     *
     * @param \Transaction\Service\TransactionService $transactionService            
     */
    public function setTransactionService($transactionService)
    {
        $this->transactionService = $transactionService;
        return $this;
    }

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // $this->cartEntity = $this->cartService->setCart()->getCartEntity();
    }

    public static function orderUid()
    {
        return uniqid("order");
    }

    public function checkoutUid()
    {
        return uniqid("checkout");
    }

    /**
     *
     * @param \Shop\Paginator\OrderUnsettledAdapter $orderPaginator            
     */
    public function setOrderPaginator($orderPaginator)
    {
        $this->orderPaginator = $orderPaginator;
        return $this;
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
     * deducts the amount from available product
     *
     * @return \Shop\Service\OrderService
     */
    private function deductFromproductQuantity()
    {
        $cartEntity = $this->cartEntity;
        
        $cartItems = $cartEntity->getCartItems();
        // get the cart content of each item
        return $this;
    }

    public function createCartOrder()
    {
        
        $em = $this->entityManager;
        $cartOrder = new CartOrders();
        $cartOrder->setCart($this->cartEntity)
            ->setTotal(floatval($this->cartService->getfinalprice()))
            -> // thisis the price of the total products
setCreatedOn(new \DateTime())
            ->setInvoice($this->invoiceEntity)
            ->setOrderStatus($em->find(OrderStatus::class, self::ORDER_STATUS_INITIATED))
            ->setOrderUid(self::orderUid())
            ->setPaymentMethod($em->find(CheckoutPaymentMethod::class, $this->checkoutPaymentMethod))
            ->setDeliveryPrice($this->deliverycalculatorService->delivery())
            -> // tthis is the price of the delivery
setIsClosed(FALSE);
        
        $em->persist($cartOrder);
        $this->cartOrderEntity = $cartOrder;
        $this->unitOfWork = $em;
        return $this;
    }
    
    public function processCheckout(int $checkoutType, $due){
        $em = $this->entityManager;
        $this->createCartOrder();
       
        $checkoutEntity = new Checkout();
        $checkoutEntity->setCartOrders($this->cartOrderEntity)
        ->setDueDate($due)
        ->setCheckoutUid(self::checkoutUid())
        ->setCreatedOn(new \DateTime())
        ->setIsOpen(TRUE)
        ->setCheckoutType($em->find(CheckoutPaymentMethod::class, $checkoutType));
        
        $em->persist($checkoutEntity);
        $this->unitOfWork = $em;
        return $this;
    }

    /**
     * @deprecated
     * @return \Shop\Service\OrderService
     */
    public function processBankCheckout()
    {
        $em = $this->entityManager;
        $this->createCartOrder();
        $dueDate = new \DateTime();
        $dueDate->add(new \DateInterval(GeneralService::ADD_8_DAYS));
        $bankCheckoutEntity = new BankCheckout();
        $bankCheckoutEntity->setCartOrders($this->cartOrderEntity)
        ->setDueDate($dueDate)
        ->setCheckoutUid(self::checkoutUid())
        ->setCreatedOn(new \DateTime())
        ->setIsOpen(TRUE);
        $em->persist($bankCheckoutEntity);
        $this->unitOfWork = $em;
        return $this;
    }

    /**
     * @deprecated
     * @return \Shop\Service\OrderService
     */
    public function processCashCheckout()
    {
        $em = $this->entityManager;
        $this->createCartOrder();
        $cashCheckoutEntity = new CashCheckout();
        $cashCheckoutEntity->setCartOrders($this->cartOrderEntity)
            ->setCheckoutUid($this->checkoutUid())
            ->setCreatedOn(new \DateTime())
            ->setIsOpen(TRUE);
        $em->persist($cashCheckoutEntity);
        $this->unitOfWork = $em;
        return $this;
    }

    public function processCardCheckout()
    {
        $em= $this->entityManager;
        
    }

    public function processWalletCheckout()
    {
        $em = $this->entityManager;
        $data['invoice'] = $this->invoiceEntity;
        $data['paymentMethod'] = TransactionService::PAYMENT_METHOD_WALLET;
        $this->createCartOrder();
        $this->transactionService->successfullTransaction($data);
        $walletCheckoutEntity = new WalletCheckout();
        $walletCheckoutEntity->setCartOrders($this->cartOrderEntity)
            ->setCheckoutUid(self::checkoutUid())
            ->setCreatedOn(new \DateTime())
            ->setIsOpen(FALSE);
        $em->persist($walletCheckoutEntity);
        // $walletCheckoutEntity
        return $this;
    }

    public function finalCheckoutPrice()
    {
        $em = $this->entityManager;
        $finalPrice = $this->cartService->getfinalprice();
        /**
         *
         * @var User $userEntity
         */
        $userEntity = $this->generalService->getUserEntity();
        $useWallet = $this->useWallet;
        $checkoutPrice = 0;
        if (intval($this->deliveryType) == GeneralService::CART_PRODUCT_HOME_DELIVERY) {
            $deliveryPrice = $this->deliverycalculatorService->delivery();
            $checkoutPrice = $finalPrice + $deliveryPrice;
        } else {
            $checkoutPrice = $finalPrice;
        }
        /**
         *
         * @var Wallet $walletEntity
         */
        $invoiceEntity = new Invoice();
        $invoiceEntity->setInvoiceStatus($em->find(InvoiceStatus::class, InvoiceService::INVOICE_STATUS_INITIATED));
        $walletEntity = $userEntity->getWallet();
        if ($useWallet == 'true' && $walletEntity != null) {
            // var_dump("momomo");
            $walletBalance = $walletEntity->getBalance() ?? 0;
            $newCheckoutPrice = 0;
            $amountPaid = 0;
            $invoiceEntity = new Invoice();
            if ($checkoutPrice > $walletBalance) {
                $checkoutPrice = $checkoutPrice - $walletBalance;
                $amountPaid = $walletBalance;
                $walletEntity->setBalance(0)->setUpdatedOn(new \DateTime());
                $invoiceEntity->setInvoiceStatus($em->find(InvoiceStatus::class, InvoiceService::INVOICE_STATUS_PART_PAYMENT));
            } else {
                $newCheckoutPrice = $walletBalance - $checkoutPrice;
                $amountPaid = $checkoutPrice;
                $checkoutPrice = 0;
                $walletEntity->setBalance($newCheckoutPrice);
                $invoiceEntity->setInvoiceStatus($em->find(InvoiceStatus::class, InvoiceService::INVOICE_STATUS_PAID));
            }
            
            $walletOrderTransactionEntity = new WalletOrderTransaction();
            $walletOrderTransactionEntity->setAmount($amountPaid)
            ->setCreatedOn(new \DateTime())
            ->setWallet($walletEntity)
            ->setWalletOrderUid(uniqid('worder'));
            $this->walletOrderTransactionEnity = $walletOrderTransactionEntity;
            $em->persist($walletOrderTransactionEntity);
            // var_dump($this->checkoutPaymentMethod);
            $transactionEntity = new Transaction();
            
            $invoiceEntity->setAmount($amountPaid)
                ->setCart($this->cartEntity)
                ->setCreatedOn(new \DateTime())
                ->setDueDate(new \DateTime())
                ->setInvoiceUid(InvoiceService::invoiceUid());
            
            $em->persist($invoiceEntity);
            
            $transactionEntity->setCreatedOn(new \DateTime())
                ->setTransactionUid(TransactionService::transactionUid())
                ->setInvoice($invoiceEntity)
                ->setTransactionType($em->find(CheckoutPaymentMethod::class, intval($this->checkoutPaymentMethod)))
                ->setTransactionStatus($em->find(TransactionStatus::class, TransactionService::TRANSACTION_STATUS_SUCCESS));
            $em->persist($transactionEntity);
            
            $walletCartTransaction = new WalletCartTransaction();
            
            $walletCartTransaction->setCart($this->cartEntity)
                ->setCreatedOn(new \DateTime())
                ->setTransaction($transactionEntity)
                ->setWallet($walletEntity);
            
            $em->persist($walletCartTransaction);
            
            $walletActivityEntity = new WalletActivity();
            $walletActivityEntity->setCreatedOn(new \DateTime())
                ->setDesc("Payment for product")
                ->setWallet($walletEntity);
            
            $em->persist($walletActivityEntity);
            
            $em->persist($walletEntity);
            // var_dump("hhhyy");
        }
        
        // do logic of if discount is available
        
        return $checkoutPrice;
    }

    /**
     *
     * @param field_type $generalService            
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return $this;
    }

    /**
     *
     * @param \Shop\Entity\Cart $cartEntity            
     */
    public function setCartEntity($cartEntity)
    {
        $this->cartEntity = $cartEntity;
        return $this;
    }

    /**
     *
     * @return the $unitOfWork
     */
    public function getUnitOfWork()
    {
        return $this->unitOfWork;
    }

    /**
     *
     * @param field_type $unitOfWork            
     */
    public function setUnitOfWork($unitOfWork)
    {
        $this->unitOfWork = $unitOfWork;
        return $this;
    }

    /**
     *
     * @param \Shop\Entity\CartOrders $cartOrderEntity            
     */
    public function setCartOrderEntity($cartOrderEntity)
    {
        $this->cartOrderEntity = $cartOrderEntity;
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

    /**
     *
     * @param \Shop\Service\CartService $cartService            
     */
    public function setCartService($cartService)
    {
        $this->cartService = $cartService;
        return $this;
    }

    /**
     *
     * @param field_type $deliveryType            
     */
    public function setDeliveryType($deliveryType)
    {
        $this->deliveryType = $deliveryType;
        return $this;
    }

    /**
     *
     * @param field_type $useWallet            
     */
    public function setUseWallet($useWallet)
    {
        $this->useWallet = $useWallet;
        return $this;
    }

    /**
     *
     * @param boolean $hasDiscount            
     */
    public function setHasDiscount($hasDiscount)
    {
        $this->hasDiscount = $hasDiscount;
        return $this;
    }

    /**
     *
     * @param \Shop\Service\DeliveryCalculatorService $deliverycalculatorService            
     */
    public function setDeliverycalculatorService($deliverycalculatorService)
    {
        $this->deliverycalculatorService = $deliverycalculatorService;
        return $this;
    }

    /**
     *
     * @param field_type $checkoutPaymentMethod            
     */
    public function setCheckoutPaymentMethod($checkoutPaymentMethod)
    {
        $this->checkoutPaymentMethod = $checkoutPaymentMethod;
        return $this;
    }

    /**
     *
     * @return the $cartOrderEntity
     */
    public function getCartOrderEntity()
    {
        return $this->cartOrderEntity;
    }
    /**
     * @param field_type $walletOrderTransactionEnity
     */
    public function setWalletOrderTransactionEnity($walletOrderTransactionEnity)
    {
        $this->walletOrderTransactionEnity = $walletOrderTransactionEnity;
        return $this;
    }
    /**
     * @return the $walletOrderTransactionEnity
     */
    public function getWalletOrderTransactionEnity()
    {
        return $this->walletOrderTransactionEnity;
    }


}

