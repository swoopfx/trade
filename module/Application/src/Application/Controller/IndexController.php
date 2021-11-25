<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\MvcEvent;
use WasabiLib\Ajax\Response;
use WasabiLib\Ajax\GritterMessage;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\DatabaseDriver;
use Doctrine\ORM\Tools\DisconnectedClassMetadataFactory;
use Doctrine\ORM\Tools\EntityGenerator;
use General\Service\GeneralService;
use Shop\Service\CartService;
use Laminas\Crypt\Password\Bcrypt;
use Wallet\Service\ReferalService;
use Google\Cloud\Core\Testing\Snippet\Container;
use Laminas\Cache\Storage\Adapter\Redis;
use React\EventLoop\Factory;
use Clue\React\EventSource\EventSource;
use Laminas\View\Model\JsonModel;
use Settings\Entity\Zone;
use Doctrine\ORM\Query;
use Shop\Entity\CartOrders;
use CsnUser\Entity\User;
use Application\Service\ApplicationService;
use Wallet\Entity\WalletCartTransaction;

class IndexController extends AbstractActionController
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var Redis
     */
    private $redisCache;

    private $completeProfileForm;

    /**
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     *
     * @var CartService
     */
    private $cartService;
    
    /**
     * 
     * @var ApplicationService
     */
    private $appService;
    
    private $cartOrderPaginator;

    public function onDispatch(MvcEvent $e)
    {
        $response = parent::onDispatch($e);
        $this->redirectPlugin()->redirectToLogout();
        $this->redirectPlugin()->roleRedirection();
        return $response;
    }

    public function __construct()
    {}

    public function indexAction()
    {
        return new ViewModel();
    }

    public function dashboardAction()
    {
        $session = $this->cartService->getShoppingSession();
        // $redis = $this->redisCache;
        // $loop = Factory::create();
        // $eventSource = new EventSource("/test", $loop);
        // $redis->flush();
        
        // if ($redis->hasItem ( $this->identity()->getId() )) {
        
        // echo $redis->getItem($this->identity()->getId());
        // }else{
        
        // $redis->setItem($this->identity()->getId(), 'User Id');
        // }
        $userEntity = $this->identity();
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function profileAction()
    {
        $redis = $this->redisCache;
        // $redis->flush();
        
//         if ($redis->hasItem($this->identity()
//             ->getId())) {
//             echo $redis->getItem($this->identity()
//                 ->getId());
//         } else {
//             $redis->setItem($this->identity()
//                 ->getId(), 'User Id');
//         }
        $viewmodel = new ViewModel();
        return $viewmodel;
    }
    
    
    public function cartOrderAction(){
        $viewModel =  new ViewModel();
        $generaService = $this->generalService;
        $appService = $this->appService;
        $id = $this->params()->fromRoute("id", NULL);
        if($id == NULL){
            $this->flashmessenger()->addErrorMessage("Identifier absent");
            $this->redirect()->toRoute("dashboard");
        }else{
            $em = $this->entityManager;
            /**
             * 
             * @var User $user
             */
            $user = $this->identity();
            $wallet = $user->getWallet();
            
            $cartOrder = $em->getRepository(CartOrders::class)->findOneBy([
                "orderUid"=>$id
            ]);
            $walletCart = NULL;
            if($wallet != NULL){
            $walletCart = $em->getRepository(WalletCartTransaction::class)->findOneBy([
                "wallet"=>$wallet->getId(),
                "cart"=>$cartOrder->getCart()->getId()
            ]);
            }
            /**
             * 
             * @var User $user
             */
            $user = $this->identity();
//            var_dump( count($cartOrder));
            $viewModel->setVariables([
                "order"=>$cartOrder,
                "fullname"=>$appService->getUserFullName(),
                "address"=>$appService->getUserAddress() ?? "",
                "phone"=>$user->getUsername() ?? "",
                'email'=>$user->getEmail() ?? '',
                "walletCart"=>$walletCart ?? NULL
                
                
            ]);
        }
        return $viewModel;
    }
    
    public function cartOrdersAction(){
        
        $viewModel = new ViewModel([
            "data"=>$this->cartOrderPaginator
        ]);
        return $viewModel;
    }

    public function tesAction()
    {
        return time();
    }

    public function getzoneAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $repo = $em->getRepository(Zone::class);
        $data = $repo->createQueryBuilder('z')
            ->select([
            'z',
            's'
        ])
            ->leftJoin('z.country', 's')
            ->where('s.id = :country')
            ->setParameters([
            'country' => 156
        ])
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
//             var_dump($data);
        $jsonModel->setVariable('data', $data);
        return $jsonModel;
    }
    
    public function testAction(){
        
    }

//     public function getnigeriastates()
//     {
//         $jsonModel = new JsonModel();
//         $em = $this->entityManager;
//         $repo = $em->getRepository($entityName)
//         return $jsonModel;
//     }

    // public function testAction()
    // {
    // $response = new Response();
    // // $gritter = new GritterMessage();
    // // $gritter->setText("HY");
    // // $gritter->setTitle("HWER");
    // // $gritter->setType(GritterMessage::TYPE_ERROR);
    // // $response->add($gritter);
    
    // $em = $this->entityManager;
    // $em->getConfiguration()->setMetadataDriverImpl(new DatabaseDriver($this->entityManager->getConnection()->getSchemaManager()));
    
    // $cmf = new DisconnectedClassMetadataFactory();
    // $cmf->setEntityManager($em);
    // $metaData = $cmf->getAllMetadata();
    // $generator = new EntityGenerator();
    
    // $generator->setUpdateEntityIfExists(true);
    // $generator->setGenerateStubMethods(true);
    // $generator->setGenerateAnnotations(true);
    // $generator->generate($metaData, "Entity");
    
    // return $this->getResponse()->setContent($response);
    // }
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
     *
     * @param field_type $completeProfileForm            
     */
    public function setCompleteProfileForm($completeProfileForm)
    {
        $this->completeProfileForm = $completeProfileForm;
        return $this;
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
     * @param \Shop\Service\CartService $cartService            
     */
    public function setCartService($cartService)
    {
        $this->cartService = $cartService;
        return $this;
    }

    /**
     *
     * @param \Laminas\Cache\Storage\Adapter\Redis $redisCache            
     */
    public function setRedisCache($redisCache)
    {
        $this->redisCache = $redisCache;
        return $this;
    }
    /**
     * @param \Application\Service\ApplicationService $appService
     */
    public function setAppService($appService)
    {
        $this->appService = $appService;
        return $this;
    }
    /**
     * @param field_type $cartOrderPaginator
     */
    public function setCartOrderPaginator($cartOrderPaginator)
    {
        $this->cartOrderPaginator = $cartOrderPaginator;
        return $this;
    }


}
