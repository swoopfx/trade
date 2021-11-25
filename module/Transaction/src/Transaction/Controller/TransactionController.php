<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Transaction for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Transaction\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\EntityManager;
use General\Service\GeneralService;
use Transaction\Service\InvoiceService;
use Laminas\View\Model\JsonModel;
use Transaction\Service\TransactionService;
use Shop\Service\OrderService;
use Shop\Service\CartService;
use Shop\Entity\CartOrders;
use Shop\Entity\OrderDeliveryType;
use Transaction\Entity\Invoice;
use CsnUser\Entity\User;
use Wallet\Entity\Wallet;
use Wallet\Entity\WalletActivity;
use Wallet\Entity\WalletActivityType;
use Wallet\Service\WalletService;
use Laminas\View\Model\ViewModel;
use Shop\Entity\OrderStatus;
use Transaction\Entity\InvoiceStatus;
use Application\Service\ApplicationService;
use Transaction\Service\FlutterwaveService;
use Transaction\Entity\Transaction;
use Transaction\Entity\TransactionStatus;
use Settings\Entity\CheckoutPaymentMethod;
use Transaction\Entity\FlutterwaveTransaction;
use Wallet\Entity\WalletOrderTransaction;

class TransactionController extends AbstractActionController
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

    /**
     *
     * @var InvoiceService
     */
    private $invoiceService;

    /**
     *
     * @var TransactionService
     */
    private $transactionService;

    /**
     *
     * @var OrderService
     */
    private $orderService;

    /**
     *
     * @var CartService
     */
    private $cartService;

    private $renderer;

    /**
     *
     * @var ApplicationService
     */
    private $appService;

    /**
     *
     * @var FlutterwaveService
     */
    private $flutterwaveService;

    /**
     *
     * @param \Transaction\Service\FlutterwaveService $flutterwaveService            
     */
    public function setFlutterwaveService($flutterwaveService)
    {
        $this->flutterwaveService = $flutterwaveService;
        return $this;
    }

    /**
     *
     * @param field_type $renderer            
     */
    public function setRenderer($renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }

    public function indexAction()
    {
        return array();
    }

    public function fooAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /transaction/transaction/foo
        return array();
    }

    private function checkoutprocess($post)
    {
        $em = $this->entityManager;
        
        $cartService = $this->cartService;
        
        /**
         *
         * @var Cart $cartEntity
         */
        $cartEntity = $cartService->setCart()->getCartEntity();
        $cartEntity->setIsSettled(TRUE)->setUpdatedOn(new \DateTime());
        $em->persist($cartEntity);
        // var_dump("orderservice");
        /**
         *
         * @var \Shop\Service\OrderService $orderService
         */
        $orderService = $this->orderService;
        
        // var_dump("cartOrderEntity");
        // var_dump($post);
        
        $checkoutPrice = $orderService->setUseWallet($post['useWallet'])
            ->setHasDiscount($post['hasDiscount'])
            ->setDeliveryType($post['deliveryMode'])
            ->setCheckoutPaymentMethod($post['paymentMethod'])
            ->setHasDiscount($post['hasDiscount'])
            ->finalCheckoutPrice();
        $dueDate = new \DateTime();
        $dueDate->add(new \DateInterval("P8D"));
        
        $invoiceService = $this->invoiceService;
        $invoiceService->setCart($cartEntity)
            ->setDueDate($dueDate)
            ->setAmountPayable($checkoutPrice)
            ->onCheckoutInvoice();
        
        /**
         *
         * @var CartOrders $cartOrderEntity
         */
        // $cartOrderEntity = '';
        $orderService->setCartEntity($cartEntity);
        
        // if ($post['paymentMethod'] == TransactionService::PAYMENT_METHOD_WALLET) {
        // $cartOrderEntity = $orderService->processCheckout($checkoutType)->getCartOrderEntity();
        // } elseif ($post['paymentMethod'] == TransactionService::PAYMENT_METHOD_BANK) {
        // $cartOrderEntity = $orderService->processBankCheckout()->getCartOrderEntity();
        // }elseif ($post['paymentMethod'] == TransactionService::PAYMENT_METHOD_CARD){
        
        // }
        
        $dueDate = new \DateTime();
        if ($post['paymentMethod'] == TransactionService::PAYMENT_METHOD_BANK) {
            
            $dueDate->add(new \DateInterval(GeneralService::ADD_8_DAYS));
        }
        $cartOrderEntity = $orderService->processCheckout($post['paymentMethod'], $dueDate)->getCartOrderEntity();
        $walletOrderTransactionEntity= $orderService->getWalletOrderTransactionEnity();
        if($walletOrderTransactionEntity != null){
            $walletOrderTransactionEntity->setCartOrder($cartOrderEntity);
        }
        /**
         *
         * @var Invoice $invoiceEntity
         */
        $invoiceEntity = $invoiceService->getInvoiceEntity();
        
        $cartOrderEntity->setInvoice($invoiceEntity)->setDeliveryType($em->find(OrderDeliveryType::class, $post['deliveryMode']));
        if ($invoiceEntity->getAmount() == 0) {
            $cartOrderEntity->setIsClosed(TRUE);
        }
        
        return [
            'cartOrderEntity' => $cartOrderEntity,
            'invoiceEntity' => $invoiceEntity,
            'invoiceService' => $invoiceService,
            "checkoutPrice" => $checkoutPrice,
            'orderService' => $orderService,
            'orderService' => $orderService
        ];
    }

    public function paywithbankAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $user = $this->identity();
        $response = $this->getResponse();
        $cartService = $this->cartService;
        $orderService = $this->orderService;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            // var_dump($post);
            try {
                
                // process payment order and cart
                $process = $this->checkoutprocess($post);
                $cartDetails = $cartService->setCart()->getCartDetails();
                
                // $viewModel = new ViewModel();
                // $viewModel->setTemplate("");
                // $viewModel->setVariables([
                // "products"=>$cartDetails
                // ]);
                $generalService = $this->generalService;
                
                $pointer["to"] = $user->getEmail();
                $pointer["fromName"] = GeneralService::APP_COMPANY_NAME;
                $pointer['subject'] = GeneralService::APP_NAME . ":: Bank Checkout ";
                
                $template['template'] = 'shop-cash-checkout-email';
                $template["var"] = [
                    "logo" => $this->url()->fromRoute('home', array(), array(
                        'force_canonical' => true
                    )) . "img/logo.png"
                
                ];
                $cartOrderEntity = $process['cartOrderEntity'];
                $cartOrderEntity->setOrderStatus($em->find(OrderStatus::class, OrderService::ORDER_STATUS_INITIATED));
                $em->flush();
                $generalService->sendMails($pointer, $template); // effect the email
                                                                 // notify admin too of an impending bank payment
                
                $jsonModel->setVariables([
                    "orderid" => $cartOrderEntity->getOrderUid()
                ]);
                $response->setStatusCode(201);
                $this->flashmessenger()->addSuccessMessage("Successfully initiated a bank payment");
            } catch (\Exception $e) {
                // var_dump($e->getMessage());
                $jsonModel->setVariables([
                    "messages" => "Something went wrong",
                    "error" => $e->getMessage() . $e->getTraceAsString()
                ]);
                $response->setStatusCode(422);
            }
        } else {
            $jsonModel->setVariables([
                'messages' => "Authorization declined"
            ]);
            $response->setStatusCode(401);
        }
        return $jsonModel;
    }

    public function paywithcardAction()
    {
        $jsonModel = new JsonModel();
        return $jsonModel;
    }

    public function paywithwalletAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $user = $this->identity();
        $response = $this->getResponse();
        $cartService = $this->cartService;
        $orderService = $this->orderService;
        
        $request = $this->getRequest();
        /**
         *
         * @var User $user
         */
        $user = $this->identity();
        $balance = ($user->getWallet() == null ? 0 : $user->getWallet()->getBalance());
        // if($balance < )
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            
            $process = $this->checkoutprocess($post);
            
            if ($process['checkoutPrice'] < $balance) {
                try {
                    // deduct from wallet
                    $finalBalance = $balance - $process['checkoutPrice'];
                    $cartOrderEntity = $process['cartOrderEntity'];
                    /**
                     *
                     * @var Wallet $walletEntity
                     */
                    $walletEntity = $user->getWallet();
                    $walletEntity->setBalance($finalBalance)->setUpdatedOn(new \DateTime());
                    
                    $walletActivity = new WalletActivity();
                    
                    $walletActivity->setCreatedOn(new \DateTime())
                        ->setDesc("Payment for order {$cartOrderEntity->getOrderUid()}")
                        ->setType($em->find(WalletActivityType::class, WalletService::WALLET_ACTIVITY_TYPE_DEBIT));
                    
                    $walletOrderTransaction = new WalletOrderTransaction();
                    $walletOrderTransaction->setAmount($process['checkoutPrice'])
                        ->setCartOrder($cartOrderEntity)
                        ->setCreatedOn(new \DateTime())
                        ->setWallet($walletEntity)
                        ->setWalletOrderUid(uniqid('worder'));
                    
                    $em->persist($walletOrderTransaction);
                    
                    $em->persist($walletEntity);
                    
                    // send email for transaction
                    
                    $generalService = $this->generalService;
                    
                    $cartOrderInfo = $cartOrderEntity->getCart()->getCartItems();
                    $cartDetails = $cartService->setCart()->getCartDetails();
                    
                    $viewModel = new ViewModel();
                    $viewModel->setTemplate("shop-checkout-partial-basket-details");
                    $viewModel->setVariables([
                        "products" => $cartDetails
                    ]);
                    $basket = $this->renderer->render($viewModel);
                    
                    $pointer["to"] = $user->getEmail();
                    $pointer["fromName"] = GeneralService::APP_COMPANY_NAME;
                    $pointer['subject'] = GeneralService::APP_NAME . ":: Wallet Checkout ";
                    
                    $template['template'] = 'shop-checkout-template';
                    $template["var"] = [
                        "logo" => $this->url()->fromRoute('home', array(), array(
                            'force_canonical' => true
                        )) . "img/logo.png",
                        "initialMessage" => 'You have selected to pay with your TANIM FITS wallet for your goods, your goods would be processed and shipped to you ',
                        "basketStatus" => 'Hooray',
                        "basketMessage" => "Since you have successfully paid with your wallet, we would love informa you that you can fund your wallet with you prepaid Master/Visa card",
                        "basket" => $basket
                    
                    ];
                    $generalService->sendMails($pointer, $template);
                    $cartOrderEntity->setOrderStatus($em->find(OrderStatus::class, OrderService::ORDER_STATUS_INITIATED));
                    $invoiceEntity = $process['invoiceEntity'];
                    $invoiceEntity->setInvoiceStatus($em->find(InvoiceStatus::class, InvoiceService::INVOICE_STATUS_PAID));
                    $em->flush();
                    
                    // deduct from the aggregated cart
                    
                    $jsonModel->setVariables([
                        "orderid" => $cartOrderEntity->getOrderUid()
                    ]);
                    
                    $response->setStatusCode(201);
                    
//                     return $jsonModel;
                } catch (\Exception $e) {
                    $jsonModel->setVariables([
                        "messages" => "Something went wrong, Please try again later"
                    ]);
                    $response->setStatusCode(422);
                }
            } else {
                $jsonModel->setVariables([
                    'messages' => "Insufficent funds in wallet"
                ]);
                $response->setStatusCode(200);
            }
            $user = $this->identity();
        }
        return $jsonModel;
    }

    public function paywithcashAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $request = $this->getRequest();
        $generalService = $this->generalService;
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            
            // var_dump($post);
        }
        return $jsonModel;
    }

    /**
     * This initiate required variables for paying with card in the shopping cart checkout page
     * returns variables like transaction reference, price, public key
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function initiatecardpaymentAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $user = $this->identity();
        $request = $this->getRequest();
        $cartService = $this->cartService;
        $orderService = $this->orderService;
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            
            try {
                $process = $this->checkoutprocess($post);
                
                $finalPrice = $process['checkoutPrice'];
                $cartOrderEntity = $process['cartOrderEntity'];
                
                $jsonModel->setVariables([
                    'public_key' => $this->flutterwaveService->getPublicKey(),
                    'email' => $user->getEmail(),
                    'name' => $this->appService->getUserFullName(),
                    'tx_ref' => TransactionService::transactionUid(),
                    'amountPayable' => $finalPrice,
                    'logo' => $this->url()
                        ->fromRoute('home', array(), array(
                        'force_canonical' => true
                    )) . "img/logo.png"
                ]);
                $response->setStatusCode(201);
            } catch (\Exception $e) {}
        }
        return $jsonModel;
    }

    public function finalizeCardpaymentAction()
    {
        $response = $this->getResponse();
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $em = $this->entityManager;
        $cartService = $this->cartService;
        $user = $this->identity();
        if ($request->isPost()) {
            $post = $request->getPost();
            
            try {
                $process = $this->checkoutprocess($post);
                
                $finalPrice = $process['checkoutPrice'];
                $cartOrderEntity = $process['cartOrderEntity'];
                
                $generalService = $this->generalService;
                
                $cartOrderInfo = $cartOrderEntity->getCart()->getCartItems();
                $cartDetails = $cartService->setCart()->getCartDetails();
                
                $viewModel = new ViewModel();
                $viewModel->setTemplate("shop-checkout-partial-basket-details");
                $viewModel->setVariables([
                    "products" => $cartDetails
                ]);
                $basket = $this->renderer->render($viewModel);
                
                $pointer["to"] = $user->getEmail();
                $pointer["fromName"] = GeneralService::APP_COMPANY_NAME;
                $pointer['subject'] = GeneralService::APP_NAME . ":: Card Checkout ";
                
                $template['template'] = 'shop-checkout-template';
                $template["var"] = [
                    "logo" => $this->url()->fromRoute('home', array(), array(
                        'force_canonical' => true
                    )) . "img/logo.png",
                    "initialMessage" => 'You have selected to pay with your TANIM FITS Card for your goods, your goods would be processed and shipped to you ',
                    "basketStatus" => 'Hooray',
                    "basketMessage" => "Since you have successfully paid with a card , your order's in. We're working to get it packed up and out the door <br> —expect a dispatch confirmation email soon <br> We believe the basket below is a reflection of what you have paid forS ",
                    "basket" => $basket
                
                ];
                
                $cartOrderEntity->setOrderStatus($em->find(OrderStatus::class, OrderService::ORDER_STATUS_INITIATED));
                $invoiceEntity = $process['invoiceEntity'];
                $invoiceEntity->setInvoiceStatus($em->find(InvoiceStatus::class, InvoiceService::INVOICE_STATUS_PAID));
                
                $transactionEntity = new Transaction();
                $transactionEntity->setCreatedOn(new \DateTime())
                    ->setInvoice($invoiceEntity)
                    ->setTransactionStatus($em->find(TransactionStatus::class, TransactionService::TRANSACTION_STATUS_SUCCESS))
                    ->setTransactionType($em->find(CheckoutPaymentMethod::class, TransactionService::PAYMENT_METHOD_CARD))
                    ->setTransactionUid($post['tx_ref']);
                
                $flutterwaveTransactionEntity = new FlutterwaveTransaction();
                $flutterwaveTransactionEntity->setAmountPaid($post['amountPaid'])
                    ->setCreatedOn(new \DateTime())
                    ->setFlwRef($post['flw_ref'])
                    ->setFlwTransactionId($post['transaction_id'])
                    ->setTransaction($transactionEntity);
                $em->flush();
                $generalService->sendMails($pointer, $template);
                $response->setStatusCode(201);
                $this->flashmessenger()->addSuccessMessage("Successfully made payment");
                $jsonModel->setVariables([
                    'redirect' => $this->url()
                        ->fromRoute("dashboard", array(), array(
                        'force_canonical' => true
                    ))
                ]);
            } catch (\Exception $e) {
                $response->setStatusCode(422);
                $jsonModel->setVariables([
                    "messages" => "Something went wrong, please try again latter",
                    'data' => $e->getMessage()
                ]);
            }
        }
        return $jsonModel;
    }

    /**
     * This is initiates payment by card at the cart order page, this is called when an invoice has already been generated
     * And the invoice needs to be executed
     * it takes the order id and get all required details from the the cart order
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function cardpaymentAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $response = $this->getResponse();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            $orderid = $post['orderid'];
            $orderuid = $post['orderuid'];
            /**
             *
             * @var User $user
             */
            $user = $this->identity();
            /**
             *
             * @var CartOrders $orderEntity
             */
            $orderEntity = $em->find(CartOrders::class, $orderid);
            // var_dump(TransactionService::transactionUid());
            
            $response->setStatusCode(201);
            $jsonModel->setVariables([
                'public_key' => $this->flutterwaveService->getPublicKey(),
                'email' => $user->getEmail(),
                'name' => $this->appService->getUserFullName(),
                'tx_ref' => TransactionService::transactionUid(),
                'amountPayable' => $orderEntity->getInvoice()
                    ->getAmount(),
                'logo' => $this->url()
                    ->fromRoute('home', array(), array(
                    'force_canonical' => true
                )) . "img/logo.png"
            ]);
        }
        return $jsonModel;
    }

    public function concludecardpaymentAction()
    {
        $jsonModel = new JsonModel();
        $user = $this->identity();
        $em = $this->entityManager;
        $response = $this->getResponse();
        $request = $this->getRequest();
        if ($request->isPost()) {
            // update cartOrder
            $post = $this->params()->fromPost();
            try {
                $cartService = $this->cartService;
                /**
                 *
                 * @var CartOrders $cartOrder
                 */
                $cartOrder = $em->find(CartOrders::class, $post['orderid']);
                /**
                 *
                 * @var Invoice $invoiceEntity
                 */
                $invoiceEntity = $cartOrder->getInvoice();
                // update invoice status
                $invoiceEntity->setInvoiceStatus($em->find(InvoiceStatus::class, InvoiceService::INVOICE_STATUS_PAID));
                
                $transactionEntity = new Transaction();
                $transactionEntity->setCreatedOn(new \DateTime())
                    ->setInvoice($invoiceEntity)
                    ->setTransactionStatus($em->find(TransactionStatus::class, TransactionService::TRANSACTION_STATUS_SUCCESS))
                    ->setTransactionType($em->find(CheckoutPaymentMethod::class, TransactionService::PAYMENT_METHOD_CARD))
                    ->setTransactionUid($post['tx_ref']);
                
                $flutterwaveTransactionEntity = new FlutterwaveTransaction();
                $flutterwaveTransactionEntity->setAmountPaid($post['amountPaid'])
                    ->setCreatedOn(new \DateTime())
                    ->setFlwRef($post['flw_ref'])
                    ->setFlwTransactionId($post['transaction_id'])
                    ->setTransaction($transactionEntity);
                
                // deduct the cart quantity from the total cart count
                
                $em->persist($flutterwaveTransactionEntity);
                $em->persist($invoiceEntity);
                $em->persist($transactionEntity);
                
                $em->flush();
                $cartDetails = $cartService->setCart($cartOrder->getCart())
                    ->getCartDetails();
                // send email to customer and admin
                $generalService = $this->generalService;
                
                // calculate delivery date
                $deliveryDate = new \DateTime();
                $deliveryDate->add(new \DateInterval("P8D"));
                
                // notify customer
                $viewModel = new ViewModel();
                $viewModel->setTemplate("transaction-order-confirmation-email-snippet");
                $viewModel->setVariables([
                    "products" => $cartDetails
                ]);
                $basket = $this->renderer->render($viewModel);
                
                //
                $pointer["to"] = $user->getEmail();
                $pointer["fromName"] = GeneralService::APP_COMPANY_NAME;
                $pointer['subject'] = GeneralService::APP_NAME . ":: Order Confirmation ";
                
                $template['template'] = 'transaction-order-confirmation-email';
                $template["var"] = [
                    "logo" => $this->url()->fromRoute('home', array(), array(
                        'force_canonical' => true
                    )) . "img/logo.png",
                    "fullname" => $this->appService->getUserFullName(),
                    "address" => $this->appService->getUserAddress(),
                    // "city"=>$this->appService->get,
                    // "country"=>'',
                    "basket" => $basket,
                    'estimatedDeliveryDate' => $deliveryDate,
                    'orderId' => $cartOrder->getOrderUid(),
                    'orderDate' => $cartOrder->getCreatedOn(),
                    'deliveryMethod' => $cartOrder->getDeliveryType()->getType(),
                    'paymentType' => $cartOrder->getPaymentMethod()->getPaymentMethod(),
                    'orderTotal' => $cartOrder->getTotal(),
                    'shipping' => $cartOrder->getDeliveryPrice(),
                    'total' => $cartOrder->getInvoice()->getAmount(),
                    'cartDetails' => $cartDetails
                
                ];
                $generalService->sendMails($pointer, $template);
                
                // deduct from the product quntity
                
                $response->setStatusCode(201);
                $this->flashmessenger()->addSuccessMessage("Thanks for paying for your goods");
                $jsonModel->setVariables([
                    "redirect" => $this->url()
                        ->fromRoute("dashboard", array(), array(
                        'force_canonical' => true
                    ))
                ]);
            } catch (\Exception $e) {
                $response->setStatusCode(422);
                $jsonModel->setVariables([
                    'messages' => "Something went wrong, please try again later",
                    'data' => $e->getTraceAsString()
                ]);
            }
        } else {
            $response->setStatusCode(401);
            $jsonModel->setVariables([
                "messages" => "Not Authorized"
            ]);
        }
        return $jsonModel;
    }

    /**
     *
     * @param \Application\Service\ApplicationService $appService            
     */
    public function setAppService($appService)
    {
        $this->appService = $appService;
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
     * @param \Transaction\Service\InvoiceService $invoiceService            
     */
    public function setInvoiceService($invoiceService)
    {
        $this->invoiceService = $invoiceService;
        return $this;
    }

    /**
     *
     * @param \Transaction\Service\TransactionService $transactionService            
     */
    public function setTransactionService($transactionService)
    {
        $this->transactionService = $transactionService;
        return $this;
    }

    /**
     *
     * @param \Shop\Service\OrderService $orderService            
     */
    public function setOrderService($orderService)
    {
        $this->orderService = $orderService;
        return $this;
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
}
