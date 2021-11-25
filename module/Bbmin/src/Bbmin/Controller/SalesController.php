<?php
namespace Bbmin\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;
use Bbmin\Paginator\OrderAdminPaginator;
use Doctrine\ORM\EntityManager;
use Shop\Entity\CartOrders;
use Shop\Service\CartService;
use Transaction\Service\TransactionService;
use Wallet\Entity\WalletOrderTransaction;
use Doctrine\ORM\Query;

/**
 *
 * @author otaba
 *        
 */
class SalesController extends AbstractActionController
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var OrderAdminPaginator
     */
    private $orderpaginator;

    /**
     *
     * @var CartService
     */
    private $cartService;

    // private $
    
    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function orderAction()
    {
        $orderPaginator = $this->orderpaginator;
        $viewModel = new ViewModel([
            'orders' => $orderPaginator
        ]);
        return $viewModel;
    }

    public function vieworderAction()
    {
        $viewModel = new ViewModel();
        $em = $this->entityManager;
        $uid = $this->params()->fromRoute();
        
        if ($uid == null) {
            $this->flashmessenger()->addErrorMessage('Absent Identifier');
            $redirect = $this->redirect()->toRoute("bbminsales/default", [
                'action' => "order"
            ]);
        }
        $cartService = $this->cartService;
        
        // var_dump($uid);
        $orderEntity = $em->getRepository(CartOrders::class)->findOneBy([
            'orderUid' => $uid["id"]
        ]);
        $cartDetails = $cartService->setCart($orderEntity->getCart())
            ->getCartDetails();
        // var_dump($orderEntity->getCart()->getId());
        $viewModel->setVariables([
            'order' => $orderEntity,
            'cartDetails' => $cartDetails
        ]);
        return $viewModel;
    }

    public function orderTransactionAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $id = $this->params()->fromRoute('id', NULL);
        if ($id != NULL) {
            /**
             *
             * @var CartOrders $cartOrderEntity
             */
            $cartOrderEntity = $em->find(CartOrders::class, $id);
            if ($cartOrderEntity->getPaymentMethod()->getId() == TransactionService::PAYMENT_METHOD_WALLET) {
                // get Wallet Transaction
                $walletTransaction = $em->getRepository(WalletOrderTransaction::class)
                    ->createQueryBuilder("w")
                    ->select("w")
                    ->where("w.cartOrder = :cartOrder")
                    ->setParameters([
                    "cartOrder" => $id
                ])
                    ->getQuery()
                    ->setHydrationMode(Query::class)
                    ->getArrayResult();
                 $jsonModel->setVariables([
                    "data" => $walletTransaction
                ]);
            } elseif ($cartOrderEntity->getPaymentMethod()->getId() == TransactionService::PAYMENT_METHOD_CARD) {
                // get Card Transaction
            }
            
            // compact it
        }
        // $orderUid =
        return $jsonModel;
    }

    public function returnsAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function reportAction()
    {
        $viewmodel = new ViewModel();
        return $viewmodel;
    }

    // Begin Json Calls
    public function orderunsettledjsonAction()
    {
        $jsonModel = new JsonModel(array());
        return $jsonModel;
    }

    /**
     *
     * @param \Bbmin\Controller\unknown $entityManager            
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     *
     * @param field_type $orderpaginator            
     */
    public function setOrderpaginator($orderpaginator)
    {
        $this->orderpaginator = $orderpaginator;
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

