<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Support for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Support\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\MvcEvent;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;
use Support\Entity\Support;
use Doctrine\ORM\EntityManager;
use Support\Service\SupportService;
use Laminas\Http\Response;
use Laminas\InputFilter\InputFilter;
use Support\Entity\SupportMessages;
use Support\Entity\SupportMessageState;
use Support\Entity\SupportStatus;

class SupportController extends AbstractActionController
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var SupportService
     */
    private $supportService;

    public function onDispatch(MvcEvent $e)
    {
        $response = parent::onDispatch($e);
        // $this->redirectPlugin()->redirectToLogout();
        return $response;
    }

    public function indexAction()
    {
        // if the support ID isset get information about the
        $supportUid = $this->params()->fromRoute("id", NULL);
        if ($supportUid != NULL) {
            return $this->redirect()->toRoute("support/default", array(
                "action" => "view",
                "id" => $supportUid
            ));
        } else {}
        return array();
    }

    public function viewAction()
    {
        $param = $this->params()->fromRoute("id", NULL);
        if ($param == NULL) {
            $this->flashmessenger()->addErrorMessage("Absent Identifier");
            $this->redirect()->toRoute("support");
        }
        $viewModel = new ViewModel();
        return $viewModel;
    }

    /**
     * This action gets the list of tickets
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function ticketsAction()
    {
        $em = $this->entityManager;
        $supportService = $this->supportService;
        $tickets = $supportService->getUserRecentSupportTicketArray();
        $jsonModel = new JsonModel(array(
            "tickets" => $tickets
        ));
        return $jsonModel;
    }

    public function converseAction()
    {
        $em = $this->entityManager;
        $id = $this->params()->fromQuery("id");
        $messageSession = $this->supportService->getMessageSession();
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isGet()) {
            $messageSession->id = $id;
            $supportArray = $em->getRepository("Support\Entity\Support")->findConversation($id);
            $supportEntityArray = $em->getRepository(Support::class)->findSurpportEntityArrayFromId($id);
            $response->setStatusCode(Response::STATUS_CODE_200);
            $jsonModel->setVariables([
                "support"=>$supportEntityArray,
                "messages" => $supportArray
            ]);
        }
        /**
         *
         * @var Support $supportEntity
         */
        
        return $jsonModel;
    }

    public function submitMessageAction()
    {
        $em = $this->entityManager;
        $request = $this->getRequest();
        $messageSession = $this->supportService->getMessageSession();
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post = $request->getPost();
            
            $id = $messageSession->id;
            /**
             *
             * @var Support $supportEntity
             */
            $supportEntity = $em->find(Support::class, $id);
            if ($supportEntity == NULL) {
                $response->setStatusCode(Response::STATUS_CODE_499);
                return $jsonModel;
            }
            $inputFilter = new InputFilter();
            $inputFilter->add(array(
                'name' => 'message',
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
                                'isEmpty' => 'Message cannot be empty'
                            )
                        )
                    )
                )
            ));
            $inputFilter->setData($post);
            if ($inputFilter) {
                $data = $inputFilter->getValues();
                try {
                    
                    $supportMessage = new SupportMessages();
                    $supportMessage->setCreatedOn(new \DateTime())
                        ->setMessageText($data["message"])
                        ->setUserState($em->find(SupportMessageState::class, SupportService::SUPPORT_MESSAGE_STATE_SENDER))
                        ->setAdminState($em->find(SupportMessageState::class, SupportService::SUPPORT_MESSAGE_STATE_RECEIVER))
                        ->setMessages($supportEntity);
                    
                    $supportEntity->setUpdatedOn(new \DateTime())->setIsActive(TRUE);
                    
                    $em->persist($supportEntity);
                    $em->persist($supportMessage);
                    $em->flush();
                    $response->setStatusCode(Response::STATUS_CODE_201);
                    $jsonModel->setVariables([
                        "msgId"=>$supportEntity->getId()
                    ]);
                } catch (\Exception $e) {
                    $jsonModel->setVariables([
                        "message"=>$e->getMessage()
                    ]);
                    $response->setStatusCode(Response::STATUS_CODE_501);
                }
            } else {
                $response->setStatusCode(Response::STATUS_CODE_422);
            }
        }
        return $jsonModel;
    }

    public function fooAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /support/support/foo
        return array();
    }

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
     * @param field_type $supportService            
     */
    public function setSupportService($supportService)
    {
        $this->supportService = $supportService;
        return $this;
    }
}
