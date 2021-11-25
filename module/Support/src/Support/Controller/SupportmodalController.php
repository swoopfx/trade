<?php
namespace Support\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use WasabiLib\Ajax\Response;
use WasabiLib\Modal\WasabiModal;
use WasabiLib\Modal\WasabiModalView;
use Laminas\View\Model\ViewModel;
use WasabiLib\Modal\WasabiModalConfigurator;
use Support\Form\SupportMessageForm;
use WasabiLib\Ajax\GritterMessage;
use Support\Service\SupportService;
use Support\Entity\Support;
use Doctrine\ORM\EntityManager;
use WasabiLib\Ajax\Redirect;
use Support\Form\SupportForm;
use Support\Entity\SupportMessages;
use General\Service\TriggerService;

/**
 * This calss handles all modal and ajax request of the support module
 *
 * @author otaba
 *        
 */
class SupportmodalController extends AbstractActionController
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    private $renderer;

    private $generralService;

    private $wysiwygForm;

    /**
     *
     * @var SupportForm
     */
    private $supportForm;

    /**
     *
     * @var SupportService
     */
    private $supportService;

    /**
     */
    public function __construct()
    {}

    /**
     * Provides action for opening a support ticket
     * @return mixed
     */
    public function openticketAction()
    {
        $em = $this->entityManager;
        $response = new Response();
        // $form = $this->wysiwygForm;
        $form = $this->supportForm;
        
        $gritter = new GritterMessage();
        $form->setAttributes(array(
            "action" => $this->url()
                ->fromRoute("supportmodal/default", array(
                "action" => "openticket"
            )),
            "method" => "POST",
            "id" => "simpleForm",
            "method" => "POST",
            "class" => "ajax_element",
            "data-ajax-loader" => "submitTicket",
            "autocomplete" => "off"
        ));
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $this->params()->fromPost();
            $supportEntity = new Support();
            $form->setData($post);
            $form->bind($supportEntity);
            
            if ($form->isValid()) {
                
                $data = $form->getData();
                $messageText = $post["supportFieldset"]["messageText"];
                $supportEntity->setCreatedOn(new \DateTime())
                    ->setIsActive(TRUE)
                    ->setStatus($em->find("Support\Entity\SupportStatus", SupportService::SUPPORT_STATUS_INITIATED))
                    ->setSupportTitle($data->getSupportTitle())
                    ->setSupportUid(SupportService::generateSupportUid())
                    ->setUser($this->identity());
                
                $supportMessageEntity = new SupportMessages();
                $supportMessageEntity->setAdminState($em->find("Support\Entity\SupportMessageState", SupportService::SUPPORT_MESSAGE_STATE_RECEIVER))
                    ->setCreatedOn(new \DateTime())
                    ->setMessageText($messageText)
                    ->setMessages($supportEntity)
                    ->setIsRead(FALSE)
                    ->setUserState($em->find("Support\Entity\SupportMessageState", SupportService::SUPPORT_MESSAGE_STATE_SENDER));
                
                $supportEntity->addConversation($supportMessageEntity);
                
                try {
                    $em->persist($supportEntity);
                    $em->persist($supportMessageEntity);
                    $em->flush();
                    
                    $message = "A ticket has been opened, a support staff would get to you";
                    $gritter->setTitle("Success");
                    $gritter->setText($message);
                    $gritter->setType(GritterMessage::TYPE_SUCCESS);
                    $gritter->setSticky(TRUE);
                    
                    $response->add($gritter);
                    $this->flashmessenger()->addSuccessMessage($message);
                    $ticketParams = array(
                        "user" => $this->identity(),
                        "suportTicketId" => $supportEntity->getId()
                    );
                    $notificationParams = array(
                        "user" => $this->identity(),
                        "data" => array(
                            "type" => "Support",
                            "id" => $supportEntity->getSupportUid()
                        
                        )
                    );
                    $this->getEventManager()->trigger(TriggerService::SUPPORT_TICKET_INITIATED, $this, $ticketParams);
                    $this->getEventManager()->trigger(TriggerService::GENERAL_NOTIFICATION_SUPPORT, $this, $ticketParams);
                    $redirect = new Redirect($this->url()->fromRoute("support/default", array(
                        "action" => "view",
                        "id" => $supportEntity->getSupportUid()
                    )));
                    $response->add($redirect);
                } catch (\Exception $e) {
                    $gritter->setTitle("ERROR");
                    $gritter->setText("We could not send your message at this time");
                    $gritter->setType(GritterMessage::TYPE_ERROR);
                    $gritter->setSticky(TRUE);
                    
                    $response->add($gritter);
                }
            } else {
                
                $gritter->setTitle("ERROR");
                $gritter->setText("Your Form is invalid pleae check and try again later");
                $gritter->setType(GritterMessage::TYPE_ERROR);
                $gritter->setSticky(TRUE);
                
                $response->add($gritter);
            }
        } else {
            
            $modal = new WasabiModal("standard");
            $viewModel = new ViewModel(array(
                "form" => $form
            ));
            $viewModel->setTemplate("support-form");
            $modal->setContent($viewModel);
            $modalView = new WasabiModalView("#wasabi", $this->renderer, $modal);
            $response->add($modalView);
        }
        return $this->getResponse()->setContent($response);
    }

    public function viewticketlistAction()
    {
        $response = new Response();
        $modal = new WasabiModal("standard");
        $supportService = $this->supportService;
        $viewModel = new ViewModel(array(
            "data" => $supportService->getUserRecentSupportTicketObject()
        ));
        $viewModel->setTemplate("support-view-ticket-list-snippet");
        $modal->setContent($viewModel);
        $modalView = new WasabiModalView("#wasabi", $this->renderer, $modal);
        $response->add($modalView);
        return $this->getResponse()->setContent($response);
    }

    public function viewTicketJson()
    {}

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
     * @param field_type $renderer            
     */
    public function setRenderer($renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }

    /**
     *
     * @param field_type $generralService            
     */
    public function setGenerralService($generralService)
    {
        $this->generralService = $generralService;
        return $this;
    }

    /**
     *
     * @param field_type $wysiwygForm            
     */
    public function setWysiwygForm($wysiwygForm)
    {
        $this->wysiwygForm = $wysiwygForm;
        return $this;
    }

    /**
     *
     * @param field_type $supportForm            
     */
    public function setSupportForm($supportForm)
    {
        $this->supportForm = $supportForm;
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

