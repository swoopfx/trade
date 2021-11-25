<?php
namespace Wallet\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\EntityManager;
use General\Service\GeneralService;
use Wallet\Service\ReferalService;
use WasabiLib\Ajax\Response;
use WasabiLib\Ajax\GritterMessage;
use WasabiLib\Modal\WasabiModal;
use WasabiLib\Modal\WasabiModalView;
use Wallet\Form\WalletReferalForm;
use Laminas\View\Model\ViewModel;
use Wallet\Entity\Refferal;
use General\Service\TriggerService;
use WasabiLib\Ajax\Redirect;

/**
 *
 * @author otaba
 *        
 */
class ReferalController extends AbstractActionController
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
     * @var ReferalService
     */
    private $referalService;

    /**
     *
     * @var WalletReferalForm
     */
    private $referalForm;

    private $renderer;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function makeAction()
    {
        $em = $this->entityManager;
        $response = new Response();
        $referalForm = $this->referalForm;
        $referalForm->setAttributes(array(
            "action" => $this->url()
            ->fromRoute("referal/default", array(
                "action" => "make"
            )),
            "method" => "POST",
            "id" => "simpleForm",
            "method" => "POST",
            "class" => "ajax_element",
            "autocomplete" => "off"
        ));
        $gritter = new GritterMessage();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $referalEntity = new Refferal();
            $params = $this->params()->fromPost();
            $referalForm->setData($params);
            $referalForm->bind($referalEntity);
            if ($referalForm->isValid()) {
                $data = $referalForm->getData();
                try {
                    $referalEntity->setCreatedOn(new \DateTime())
                        ->setIsRegistered(FALSE)
                        ->setReferalCode(ReferalService::generateReferalCode())
                        ->setReferalUid(uniqid(rand()))
                        ->setUser($this->identity());
                    
                        $em->persist($referalEntity);
                        $em->flush();
                        $param = array(
                            "user"=>$this->identity(),
                            "email"=>$data->getReferalEmail(),
                            "phone"=>$data->getReferalPhone(),
                        );
                         
                        $this->getEventManager()->trigger(TriggerService::REFERAL_INITIATED, $this, $param);
                        
                        $gritter->setTitle("SUCCESS");
                        $gritter->setText("Successfully sent a referal request ");
                        $gritter->setType(GritterMessage::TYPE_SUCCESS);
                        $gritter->setSticky(TRUE);
                        
                        $response->add($gritter);
                        $this->flashmessenger()->addSuccessMessage("Successfully sent a referal request ");
                        $redirect = new Redirect($this->url()->fromRoute("application/default", array("action"=>"profile")));
                        
                        $response->add($redirect);
                } catch (\Exception $e) {
                    $gritter->setTitle("ERROR");
                    $gritter->setText("Referal could not be initiated ");
                    $gritter->setType(GritterMessage::TYPE_ERROR);
                    $gritter->setSticky(TRUE);
                    
                    $response->add($gritter);
                }
            } else {
                $gritter->setTitle("ERROR");
                $gritter->setText("Referal could not be initiated ");
                $gritter->setType(GritterMessage::TYPE_ERROR);
                $gritter->setSticky(TRUE);
                
                $response->add($gritter);
            }
        } else {
            $modal = new WasabiModal("standard");
            
            $viewModel = new ViewModel(array(
                "form" => $referalForm
            ));
            $viewModel->setTemplate("wallet-referal-form");
            $modal->setContent($viewModel);
            $modalView = new WasabiModalView("#wasabi", $this->renderer, $modal);
            
            $response->add($modalView);
        }
        
        return $this->getResponse()->setContent($response);
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
     * @param \Wallet\Service\ReferalService $referalService            
     */
    public function setReferalService($referalService)
    {
        $this->referalService = $referalService;
        return $this;
    }

    /**
     *
     * @return the $renderer
     */
    public function getRenderer()
    {
        return $this->renderer;
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
     * @param \Wallet\Form\WalletReferalForm $referalForm            
     */
    public function setReferalForm($referalForm)
    {
        $this->referalForm = $referalForm;
        return $this;
    }
}

