<?php
namespace Shop\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use General\Service\GeneralService;
use Doctrine\ORM\EntityManager;
use WasabiLib\Ajax\Response;
use WasabiLib\Modal\WasabiModal;
use WasabiLib\Modal\WasabiModalView;
use Laminas\View\Model\JsonModel;
use Shop\Service\ProductService;
use Shop\Entity\Category;
use Shop\Service\CartService;
use Shop\Entity\BillingDetails;
use Doctrine\ORM\Query;
use Laminas\InputFilter\InputFilter;
use Settings\Entity\Country;
use Laminas\Db\Sql\Ddl\Column\Date;
use Settings\Entity\Zone;
use Application\Service\ApplicationService;
use Settings\Entity\CheckoutPaymentMethod;
use Shop\Entity\OrderDeliveryType;
use CsnUser\Entity\User;
use User\Entity\UserProfile;
use Shop\Service\DeliveryCalculatorService;
use Shop\Service\OrderService;
use Shop\Entity\Cart;
use Transaction\Service\InvoiceService;

/**
 *
 * @author otaba
 *        
 */
class ShopajaxController extends AbstractActionController
{

    /**
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var ApplicationService
     */
    private $applicationService;

    // private $
    
    /**
     *
     * @var
     *
     */
    private $renderer;

    /**
     *
     * @var ProductService
     */
    private $producService;

    /**
     *
     * @var CartService
     */
    private $cartService;

    /**
     *
     * @var DeliveryCalculatorService
     */
    private $deliveryCalculatorService;

    /**
     *
     * @var OrderService
     */
    private $orderService;

    /**
     *
     * @var InvoiceService
     */
    private $invoiceService;

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function postbillingaddressAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $em = $this->entityManager;
        $user = $this->identity();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $billigDetaillsEntity = $em->getRepository(BillingDetails::class)->findOneBy([
                "user" => $user->getId()
            ]);
            if ($billigDetaillsEntity == null) {
                $billigDetaillsEntity = new BillingDetails();
            }
            $inputFilter = new InputFilter();
            
            $inputFilter->add(array(
                'name' => 'seletedState',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'State is required'
                            )
                        )
                    )
                )
            ));
            
            $inputFilter->add(array(
                'name' => 'address1',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Address is required'
                            )
                        )
                    )
                )
            ));
            
            $inputFilter->add(array(
                'name' => 'city',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Please indicate the City'
                            )
                        )
                    )
                )
            ));
            
            $inputFilter->setData($post);
            if ($inputFilter->isValid()) {
                $data = $inputFilter->getValues();
                $billigDetaillsEntity->setBillingAddress1($data['address1'])
                    ->setBillingAddress2($post['address2'])
                    ->setBillingCity($data['city'])
                    ->setBillingCountry($em->find(Country::class, 156))
                    ->setUser($user)
                    ->setZone($em->find(Zone::class, $data['seletedState']))
                    ->setCreatedOn(new \DateTime());
                
                $em->persist($billigDetaillsEntity);
                
                $em->flush();
                
                $jsonModel->setVariables([]);
                $response->setStatusCode(201);
            } else {
                $jsonModel->setVariables([
                    'messages' => $inputFilter->getMessages()
                ]);
                $response->setStatusCode(400);
            }
        }
        return $jsonModel;
    }

    public function getbillingstatusAction(): JsonModel
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $em = $this->entityManager;
        /**
         *
         * @var User $user
         */
        $user = $this->identity();
        // $repo = $em->getRepository(BillingDetails::class);
        // $billingstatus = $repo->createQueryBuilder('b')
        // ->select([
        // 'b',
        // 'u',
        // 's',
        // 'c'
        // ])
        // ->leftJoin('b.user', 'u')
        // ->leftJoin('b.billingCountry', 'c')
        // ->leftJoin('b.zone', 's')
        // ->where('u.id = :user')
        // ->setParameters([
        // 'user' => $user->getId()
        // ])
        // ->getQuery()
        // ->getResult(Query::HYDRATE_ARRAY);
        
        /**
         *
         * @var UserProfile $userAddress
         */
        $userAddress = $em->getRepository("User\Entity\UserProfile")->findOneBy(array(
            "user" => $user->getId()
        ));
        $data = [
            'billingAddress1' => $userAddress->getAddress1(),
            // 'billingAddress2' =>$userAddress->getA
            'billingCity' => $userAddress->getState()->getName(),
            'billingCountry' => [
                'name' => $userAddress->getCountry()->getName()
            ],
            'zone' => [
                'name' => $userAddress->getState()->getName()
            ],
            'user' => [
                'username' => $user->getUsername(),
                'email' => $user->getEmail()
            ]
            // 'billingCountry'=>
        ];
        $jsonModel->setVariables([
            // 'data' => $billingstatus == null ? $billingstatus : $billingstatus[0],
            'data' => $data,
            'fullname' => $this->applicationService->getUserFullName()
        ]);
        $response->setStatusCode(200);
        return $jsonModel;
    }

    public function topratedproductsajaxAction()
    {
        $response = new Response();
        $modal = new WasabiModal("standard");
        $modalView = new WasabiModalView("#wasabi", $this->renderer, $modal);
        $response->add($modalView);
        return $this->getResponse()->setContent($response);
    }

    /**
     * Returns the dashboard carousel information
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function dashboardproductcarouselAction()
    {
        $productService = $this->producService;
        $data = $productService->getMostRecentProduct();
        $response = $this->getResponse();
        $response->setStatusCode(200);
        $json = new JsonModel(array(
            "product" => $data
        ));
        return $json;
    }

    /**
     * Gets a list of all category
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function getShopCategoryAction()
    {
        $em = $this->entityManager;
        $response = $this->getResponse();
        $category = $em->getRepository(Category::class)->getAllCategoryArray();
        $response->setStatusCode(200);
        $jsonModel = new JsonModel([
            "category" => $category
        ]);
        
        return $jsonModel;
    }

    public function getcartAction()
    {
        $jsonModel = new JsonModel();
        return $jsonModel;
    }

    /**
     * gets a structure array of the available cart details
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function getcartdetailsAction()
    {
        $cartService = $this->cartService;
        $jsonModel = new JsonModel([
            'cartdetails' => $cartService->getCartDetails()
        ]);
        return $jsonModel;
    }

    /**
     * Inserts an intem into the CartItem entity
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function insertitemAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $cartService = $this->cartService;
            $cartService->setCart()
                ->getCartItemService()
                ->insertItem();
        }
        return $jsonModel;
    }

    public function orderDeliveryTypeAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $repo = $em->getRepository(OrderDeliveryType::class);
        $data = $repo->createQueryBuilder('c')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        $jsonModel->setVariables([
            'data' => $data
        ]);
        return $jsonModel;
    }

    /**
     * Return a list of checkout methods
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function checkoutPaymentMethodAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $repo = $em->getRepository(CheckoutPaymentMethod::class);
        $data = $repo->createQueryBuilder('c')
        ->where("c.isActive = :active")
        ->setParameters([
            'active'=>TRUE
        ])
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        $jsonModel->setVariables([
            'data' => $data
        ]);
        return $jsonModel;
    }

    /**
     * Gets the price of delivering the product to the customer address
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function deliveryPriceAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $deliveryPrice = 0;
        if ($request->isPost()) {
            $post = $request->getPost();
            
            if ($post['delivery'] == 10) {
                $deliveryPrice = 0;
            } else {
                $deliveryPrice = $this->deliveryCalculatorService->delivery();
            }
            
            $jsonModel->setVariables([
                'data' => $deliveryPrice
            ]);
            $response->setStatusCode(200);
        }
        return $jsonModel;
    }

    public function bankCheckoutAction()
    {
//         $jsonModel = new JsonModel();
//         $em = $this->entityManager;
//         $response = $this->getResponse();
//         $cartService = $this->cartService;
//         $request = $this->getRequest();
//         if ($request->isPost()) {
//             $post = $request->getPost();
//             try {
                
//                 /**
//                  *
//                  * @var Cart $cartEntity
//                  */
//                 $cartEntity = $cartService->setCart()->getCartEntity();
//                 $cartEntity->setIsSettled(TRUE)->setUpdatedOn(new \DateTime());
//                 $em->persist($cartEntity);
//                 /**
//                  *
//                  * @var \Shop\Service\OrderService $orderService
//                  */
//                 $orderService = $this->orderService;
//                 $orderService->processBankCheckout()->getUnitOfWork();
                
//                 $dueDate = new \DateTime();
//                 $dueDate->add(new \DateInterval("P8D"));
//                 $invoiceService = $this->invoiceService;
//                 $invoiceService->setCart($cartEntity)
//                     ->setDueDate($dueDate)
//                     ->setAmountPayable('calculated from the parameters sent in');
                
//                 $em->flush();
                
//                 // send email to customer of the procedure of payment 
//                 // notify admin too of an impending bank payment
                
//             } catch (\Exception $e) {
//                 $jsonModel->setVariables([
//                     "messages" => "Something went wrong"
//                 ]);
//                 $response->setStatusCode(422);
//             }
//         } else {
//             $jsonModel->setVariables([
//                 'messages' => "Authorization declined"
//             ]);
//             $response->setStatusCode(401);
//         }
//         return $jsonModel;
    }

    public function cashCheckoutAction()
    {
        $jsonModel = new JsonModel();
        return $jsonModel;
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
     * @param \Doctrine\ORM\EntityManager $entityManager            
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
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

    /**
     *
     * @param \Shop\Service\ProductService $producService            
     */
    public function setProducService($producService)
    {
        $this->producService = $producService;
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
     * @param \Application\Service\ApplicationService $applicationService            
     */
    public function setApplicationService($applicationService)
    {
        $this->applicationService = $applicationService;
        return $this;
    }

    /**
     *
     * @param \Shop\Service\DeliveryCalculatorService $deliveryCalculatorService            
     */
    public function setDeliveryCalculatorService($deliveryCalculatorService)
    {
        $this->deliveryCalculatorService = $deliveryCalculatorService;
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
     * @param \Transaction\Service\InvoiceService $invoiceService            
     */
    public function setInvoiceService($invoiceService)
    {
        $this->invoiceService = $invoiceService;
        return $this;
    }
}

