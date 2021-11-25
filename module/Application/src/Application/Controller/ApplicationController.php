<?php
namespace Application\Controller;

use Application\Service\ApplicationService;
use CsnUser\Entity\User;
use CsnUser\Service\UserService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use General\Service\GeneralService;
use General\Service\TriggerService;
use Laminas\Authentication\AuthenticationService;
use Laminas\Form\Form;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;
use Shop\Entity\CartOrders;
use Transaction\Entity\NotifyPayment;
use Transaction\Form\NotifyPaymentForm;
use Transaction\Service\TransactionService;
use User\Entity\UserProfile;
use User\Form\UserProfileForm;
use WasabiLib\Ajax\GritterMessage;
use WasabiLib\Ajax\Redirect;
use WasabiLib\Ajax\Response;
use WasabiLib\Modal\WasabiModal;
use WasabiLib\Modal\WasabiModalView;

/**
 *
 * @author otaba
 *
 */
class ApplicationController extends AbstractActionController
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var unknown
     */
    private $renderer;

    /**
     *
     * @var AuthenticationService
     */
    private $auth;

    /**
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     *
     * @var UserProfileForm
     */
    private $completeProfileForm;

    /**
     *
     * @var NotifyPaymentForm
     */
    private $notifyPaymentForm;

    /**
     *
     * @var ApplicationService
     */
    private $applicationService;

    /**
     *
     * @param \Transaction\Form\NotifyPaymentForm $notifyPaymentForm
     */
    public function setNotifyPaymentForm($notifyPaymentForm)
    {
        $this->notifyPaymentForm = $notifyPaymentForm;
        return $this;
    }

    /**
     */
    public function __construct()
    {

        // TODO - Insert your code here
    }

    public function contactusmodalAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post = $request->getPost();

            $generalService = $this->generalService;
            $pointer["to"] = GeneralService::COMPANY_SUPPORT_EMAIL;
            $pointer["fromName"] = GeneralService::APP_COMPANY_NAME;
            $pointer['subject'] = GeneralService::APP_NAME . ":: Form Filled ";
            $pointer['replyTo'] = strip_tags($post['email']);

            $template['template'] = 'shop-checkout-template';
            $template["var"] = [
                "logo" => $this->url()->fromRoute('home', array(), array(
                    'force_canonical' => true,
                )) . "img/logo.png",
                "subject" => strip_tags($post['subject']),
                'name' => strip_tags($post['name']),
                'message' => strip_tags($post['message']),

            ];
            $generalService->sendMails($pointer, $template);

            $response->setStatusCode(201);
            $jsonModel->setVariables([]);
        }
        {
            $response->setStatusCode(401);
            $jsonModel->setVariables([
                'messages' => "Your are not authorized",
            ]);
        }
        return $jsonModel;
    }

    public function notifypaymentmodalAction()
    {
        $response = new Response();
        $id = $this->params()->fromQuery("ddd", null);
        $form = $this->notifyPaymentForm;
        $gritter = new GritterMessage();
        $user = $this->identity();
        $form->setAttributes(array(
            "action" => $this->url()
                ->fromRoute("appmodal/default", array(
                    "action" => "notifypaymentmodal",
                )),
            "method" => "POST",
            "data-ajax-loader" => "profileaction",
            "id" => "simpleForm",
            "method" => "POST",
            "class" => "ajax_element",
            "autocomplete" => "off",
        ));
        $form->add(array(
            "name" => "cartOrder",
            "type" => "hidden",

            'attributes' => [
                'value' => $id,
            ],

        ));
        $em = $this->entityManager;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $this->params()->fromPost();
            $form->setData($post);
            $notifyPaymentEntity = new NotifyPayment();
            $form->bind($notifyPaymentEntity);
            if ($form->isValid()) {
                // process form

                $data = $form->getData();
                try {
                    $notifyPaymentEntity->setCartOrder($em->find(CartOrders::class, $post['cartOrder']))
                        ->setCreatedOn(new \DateTime())
                        ->setPaymentUid(TransactionService::notifyPaymentUid());
                    $em->persist($notifyPaymentEntity);
                    $em->flush();

                    // send email to user
                    $generalService = $this->generalService;

                    $pointer["to"] = $user->getEmail();
                    $pointer["fromName"] = GeneralService::APP_COMPANY_NAME;
                    $pointer['subject'] = GeneralService::APP_NAME . ":: PAYMENT NOTIFICATION ";

                    $template['template'] = 'transaction-notify-payment-email-snippet';
                    $template["var"] = [
                        "logo" => $this->url()->fromRoute('home', array(), array(
                            'force_canonical' => true,
                        )) . "img/logo.png",
                        'name' => "",

                    ];
                    $generalService->sendMails($pointer, $template);
                    // notify admin of

                    $redirect = new Redirect($this->url()->fromRoute("dashboard"));
                    $this->flashmessenger()->addSuccessMessage("Success, we will process your payment, and update you cart");
                    $response->add($redirect);
                } catch (\Exception $e) {
                    $gritter->setTitle("Hydration Error");
                    $gritter->setText("We could not submit your form, please try again latter");
                    $gritter->setType(GritterMessage::TYPE_ERROR);
                    $response->add($gritter);
                }
            } else {
                $gritter->setTitle("Invalid Form");
                $gritter->setText("Please check your submitted form, as it appears to be invalid");
                $gritter->setType(GritterMessage::TYPE_ERROR);
                $response->add($gritter);
            }
        } else {
            $modal = new WasabiModal("standard");
            $viewModel = new ViewModel(array(
                "form" => $form,
            ));
            $viewModel->setTemplate("transaction-notify-payment-form-snippet");
            // $modal->setSize(WasabiModal::LARGE_SIZE);
            $modalView = new WasabiModalView("#wasabi", $this->renderer, $modal);
            $modal->setContent($viewModel);
            $response->add($modalView);
        }
        return $this->getResponse()->setContent($response);
    }

    public function changepasswordAction()
    {
        $response = new Response();
        $form = new Form();
        $form->setAttributes([

        ]);
        $form->add([
            "name" => "newpassword",
            "type" => "password",
            "options" => [
                "label" => "New Password",
                "label_attributes" => [
                    'class' => "",
                ],
            ],
            "attributes" => [
                'class'=>"form-control",

            ],
        ]);
        $form->add([
            "name" => "newpassword",
            "type" => "password",
            "options" => [
                "label" => "New Password",
                "label_attributes" => [
                    'class' => "",
                ],
            ],
            "attributes" => [
                'class'=>"form-control",
                
            ],
        ]);
        $request = $this->getRequest();
        if($request->isPost()){
            
        }
        return $this->getResponse()->setContent($response);
    }

    public function completetprofilemodalAction()
    {
        $form = $this->completeProfileForm;
        $form->setAttributes(array(
            "action" => $this->url()
                ->fromRoute("appmodal/default", array(
                    "action" => "completetprofilemodal",
                )),
            "method" => "POST",
            "data-ajax-loader" => "profileaction",
            "id" => "simpleForm",
            "method" => "POST",
            "class" => "ajax_element",
            "autocomplete" => "off",
        ));
        $response = new Response();
        $em = $this->entityManager;
        $request = $this->getRequest();
        $gritter = new GritterMessage();
        if ($request->isPost()) {
            $post = $this->params()->fromPost();
            /**
             *
             * @var User
             */
            $userEntity = $this->identity();
            // $userId = $userEntity->getId();
            // $profileEntity = $em->getRepository("User\Entity\UserProfile")->findOneBy(array(
            // "user"=>$userId
            // ));

            $profileEntity = new UserProfile();
            $form->setData($post);
            $form->bind($profileEntity);
            if ($form->isValid()) {
                $data = $form->getData();
                $profileEntity->setCreatedOn(new \DateTime())
                    ->setUser($userEntity)
                    ->setUserLevel($em->find("Settings\Entity\UserLevel", GeneralService::USER_LEVEL_BEGINNER));

                $userEntity->setIsProfiled(true)
                    ->setUpdatedOn(new \DateTime())
                    ->setRole($em->find("CsnUser\Entity\Role", UserService::USER_ROLE_PROFILED));
                try {

                    $em->persist($profileEntity);
                    $em->persist($userEntity);
                    $em->flush();
                    $params = array(
                        "user" => $userEntity->getId(),
                    );
                    $this->getEventManager()->trigger(TriggerService::USER_REGISTER_COMPLETE, $this, $params);
                    $redirect = new Redirect($this->url()->fromRoute("home"));
                    $this->flashmessenger()->addSuccessMessage("Hurray you made it ");
                    $response->add($redirect);
                } catch (\Exception $e) {
                    $gritter->setTitle("Hydration Error");
                    $gritter->setText("We could not submit your form, please try again latter");
                    $gritter->setType(GritterMessage::TYPE_ERROR);
                    $response->add($gritter);
                }
            } else {
                $gritter->setTitle("Validation Error");
                $gritter->setText("Your form does not meet minimum validation requirement");
                $gritter->setType(GritterMessage::TYPE_ERROR);
                $response->add($gritter);
            }
        } else {
            $modal = new WasabiModal("standard");
            $viewModel = new ViewModel(array(
                "form" => $form,
            ));
            $viewModel->setTemplate("user-user-profile-form");
            // $modal->setSize(WasabiModal::LARGE_SIZE);
            $modalView = new WasabiModalView("#wasabi", $this->renderer, $modal);
            $modal->setContent($viewModel);
            $response->add($modalView);
        }
        return $this->getResponse()->setContent($response);
    }

    /**
     *
     * @return mixed
     */
    public function editprofileAction()
    {
        $form = $this->completeProfileForm;
        $em = $this->entityManager;
        $gritter = new GritterMessage();
        $response = new Response();
        $applicationService = $this->applicationService;
        /**
         *
         * @var UserProfile $profileEntity
         */
        $profileEntity = $applicationService->getUserProfile();
        $form->setAttributes(array(
            "action" => $this->url()
                ->fromRoute("appmodal/default", array(
                    "action" => "editprofile",
                )),
            "method" => "POST",
            "id" => "simpleForm",
            "method" => "POST",
            "class" => "ajax_element",
            "autocomplete" => "off",
            "data-ajax-loader" => "profileaction",
        ));
        $form->bind($profileEntity);
        $submit = $form->get("submit");
        $submit->setAttributes(array(
            "value" => "EDIT PROFILE",
        ));
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $this->params()->fromPost();
            $form->setData($post);
            if ($form->isValid()) {
                try {
                    $profileEntity->setUpdatedOn(new \DateTime());

                    $em->persist($profileEntity);

                    $em->flush();
                    $gritter->setTitle("SUCCESS");
                    $gritter->setText("Successfully updated profile");
                    $gritter->setType(GritterMessage::TYPE_SUCCESS);
                    $params = array(
                        "user" => $this->identity(),
                    );
                    $this->getEventManager()->trigger(TriggerService::USER_EDIT_PROFILE, $this, $params);

                    $response->add($gritter);
                    $this->flashmessenger()->addSuccessMessage("Successfully updated profile");
                    $redirect = new Redirect($this->url()->fromRoute("application/default", array(
                        "action" => "profile",
                    )));

                    $response->add($redirect);
                } catch (\Exception $e) {
                    $gritter->setTitle("ERROR");
                    $gritter->setText("We could not update form at this moment");
                    $gritter->setType(GritterMessage::TYPE_ERROR);

                    $response->add($gritter);
                }
            } else {
                // form is invalid
                // throw gritter
            }
        } else {

            $modal = new WasabiModal("standard");
            $viewModel = new ViewModel(array(
                "form" => $form,
            ));
            $viewModel->setTemplate("user-user-profile-form");
            $modal->setContent($viewModel);
            $modalView = new WasabiModalView("#wasabi", $this->renderer, $modal);
            $response->add($modalView);
        }
        return $this->getResponse()->setContent($response);
    }

    /**
     *
     * @return mixed
     */
    public function viewcartAction()
    {
        $response = new Response();
        $modal = new WasabiModal("standard");
        $modalView = new WasabiModalView("#wasabi", $this->renderer, $modal);
        $response->add($modalView);
        return $this->getResponse()->setContent($response);
    }

    public function cartOrdersAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $user = $this->identity();
        $em = $this->entityManager;

        $repo = $em->getRepository(CartOrders::class);
        $data = $repo->createQueryBuilder('o')
            ->select([
                'o',
                'c',
                'i',
                'p',
                'm',
                'd',
                'pm',
                'os',
            ])
            ->leftJoin("o.cart", 'c')
            ->leftJoin('o.paymentMethod', 'pm')
            ->leftJoin('o.orderStatus', 'os')
            ->leftJoin('c.cartItems', 'i')
            ->leftJoin('i.product', 'p')
            ->leftJoin('p.image', 'm')
            ->leftJoin('p.productDescription', 'd')
            ->where('c.user = :user')
            ->setParameters([
                "user" => $user->getId(),
            ])
            ->setMaxResults(10)
            ->orderBy('o.id', 'DESC')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        $jsonModel->setVariables([
            'data' => $data,

        ]);
        $response->setStatusCode(200);
        return $jsonModel;
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
     * @param \Application\Controller\unknown $renderer
     */
    public function setRenderer($renderer)
    {
        $this->renderer = $renderer;
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
     * @param \General\Service\GeneralService $generalService
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return $this;
    }

    /**
     *
     * @param \User\Form\UserProfileForm $completeProfileForm
     */
    public function setCompleteProfileForm($completeProfileForm)
    {
        $this->completeProfileForm = $completeProfileForm;
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
}
