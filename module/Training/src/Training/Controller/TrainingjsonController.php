<?php
namespace Training\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\EntityManager;
use Training\Service\TrainingService;
use Laminas\View\Model\JsonModel;
use Training\Entity\Training;
use Training\Entity\UserTraining;
use WasabiLib\Ajax\Response;
use WasabiLib\Modal\WasabiModal;
use WasabiLib\Modal\WasabiModalView;
use WasabiLib\Ajax\GritterMessage;
use Training\Entity\Programmes;
use Training\Entity\Course;
use Laminas\View\Model\ViewModel;
use WasabiLib\Modal\WasabiModalConfigurator;
use Doctrine\ORM\Query;
use Training\Entity\TrainingAssigmentMilestone;
use Laminas\Form\Form;
use Training\Entity\TrainingMilestoneResources;
use Training\Entity\UserTrainingSubmitStatus;
use Training\Entity\UserTrainingActivity;
use General\Service\GeneralService;
use Training\Entity\UserSubmittedTrainingAssignment;
use WasabiLib\Ajax\Redirect;

/**
 *
 * @author otaba
 *        
 */
class TrainingjsonController extends AbstractActionController
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var TrainingService
     */
    private $trainingService;

    private $showAssignmentForm;

    private $renderer;

    private $generalService;

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
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function getcourseAction()
    {
        $response = new Response();
        $em = $this->entityManager;
        $programmeId = $this->params()->fromQuery("data", NULL);
        
        if ($programmeId == NULL) {
            $gritter = new GritterMessage();
            $gritter->setType(GritterMessage::TYPE_ERROR);
            $gritter->setTitle("IDENTIFIER ERROR");
            $gritter->setText("System cannot find identifier");
            $response->add($gritter);
        } else {
            $course = $em->getRepository(Course::class)->findBy([
                'progammes' => $programmeId
            ]);
            
            $modal = new WasabiModal('standard');
            $modal->setSize(WasabiModalConfigurator::MODAL_LG);
            $viewModel = new ViewModel([
                'courses' => $course
            ]);
            $viewModel->setTemplate("training-list-course-snippet");
            
            $modal->setContent($viewModel);
            $modalView = new WasabiModalView("#wasabi", $this->renderer, $modal);
            $response->add($modalView);
        }
        
        return $this->getResponse()->setContent($response);
    }

    public function aggregaterewardAction()
    {
        // var_dump($this->trainingService->aggregatereward());
        $response = $this->getResponse();
        $response->setStatusCode(200);
        $jsonModel = new JsonModel([
            "reward" => $this->trainingService->aggregatereward()
        
        ]);
        return $jsonModel;
    }

    /**
     * This gets an instance of the UserTraining to notify
     * if the user has registered for the specific training
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function usertrainingAction()
    {
        $em = $this->entityManager;
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $user = $this->identity();
        $trainingUid = $this->params()->fromRoute("id");
        $trainingEntity = $em->getRepository(Training::class)->findOneBy([
            "trainingUid" => $trainingUid
        ]);
        
        $userTraining = $em->getRepository(UserTraining::class)->findOneBy([
            "training" => $trainingEntity->getId(),
            "user" => $user->getId()
        ]);
        $response->setStatusCode(200);
        $data = "";
        if ($userTraining == null) {
            $data = false;
        } else {
            $data = True;
        }
        $jsonModel->setVariable("data", $data);
        return $jsonModel;
    }

    public function similartrainingAction()
    {
        $jsonModel = new JsonModel();
        $respnse = $this->getResponse();
        $em = $this->entityManager;
        $id = $this->params()->fromRoute("id", NULL);
        // $milestone ?? null;
        /**
         *
         * @var Training $activeTraining
         */
        $activeTraining = $em->find(Training::class, $id);
        // var_dump();
        $repo = $em->getRepository(Training::class);
        // var_dump($id);
        $datas = $repo->createQueryBuilder("t")
            ->select([
            't',
            'i'
        ])
            ->leftJoin("t.image", "i")
            ->
        // ->where("t.trainingMilestone = :milestone")
        andWhere("t.id != :id")
            ->andWhere("t.isPublished = :pub")
            ->setParameters([
            // "milestone" => ( count($activeTraining->getTrainingMilestone()) == 0 ? NULL : )
            'id' => $id,
            "pub" => TRUE
        ])
            ->setMaxResults(3)
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        // var_dump($data);
        // $random_keys = array_rand($data, 3);
        
        // $list[0] = $data[$random_keys[0]];
        // $list[1] = $data[$random_keys[1]];
        // $list[2] = $data[$random_keys[2]];
        
        $data = [];
        
        for ($i = 0; $i < 3; $i ++) {
            $data[$i] = $datas[array_rand($datas)];
        }
        
        $jsonModel->setVariables([
            "data" => $data
        ]);
        return $jsonModel;
    }

    /**
     * Used to asynchronously show modal WYSIWYG form for
     *
     * @return mixed
     */
    public function showAssignmentResponseViewAction()
    {
        $response = new Response();
        $modal = new WasabiModal("standard");
        $modal->setSize(WasabiModalConfigurator::MODAL_LG);
        $em = $this->entityManager;
        $user = $this->identity();
        $id = $this->params()->fromQuery("data", NULL);
        /**
         *
         * @var TrainingAssigmentMilestone $data
         */
        $data = $em->find(TrainingAssigmentMilestone::class, $id);
        /**
         *
         * @var Form $form
         */
        $form = $this->showAssignmentForm;
        $form->setAttributes([
            "id" => "simpleForm",
            "class" => "form-horizontal form-label-left ajax_element",
            "data-ajax-loader" => "selectObjectLoader",
            "action" => $this->url()
                ->fromRoute("trainingjson/default", array(
                "action" => "post-assignment"
            ))
        ]);
        $fieldset = $form->get("submitMilestoneAnswerFieldset");
        $fieldset->get("answerss")->setOptions([
            "label" => "Milestone Answer To : {$data->getTopic()}"
        ]);
        $fieldset->get("milestone")->setValue($id);
        $fieldset->get("trainingId")->setValue($data->getTraining()
            ->getId());
        $fieldset->get("answerss")->setAttributes([
            "value" => ""
        ]);
        
        $userTrainingEntity = $em->getRepository(UserTraining::class)->findOneBy([
            "user" => $user->getId(),
            "training" => $data->getTraining()
                ->getId()
        ]);
        
        /**
         *
         * @var UserSubmittedTrainingAssignment $submittedEntity
         */
        $submittedEntity = $em->getRepository(UserSubmittedTrainingAssignment::class)->findOneBy([
            "userTraining" => $userTrainingEntity->getId(),
            "milestone" => $id
        ]);
        
        // var_dump(base64_decode($submittedEntity->getAnswerss()));
        
        if ($submittedEntity != NULL) {
            $fieldset->get("answerss")->setAttributes([
                "value" => base64_decode($submittedEntity->getAnswerss())
            ]);
        }
        
        $viewModel = new ViewModel([
            'form' => $form
        ]);
        $viewModel->setTemplate("training-user-wysiwyg-submit-answer-form");
        
        $modal->setContent($viewModel);
        
        $modalView = new WasabiModalView("#wasabi", $this->renderer, $modal);
        $response->add($modalView);
        return $this->getResponse()->setContent($response);
    }

    /**
     * Shows resources assgneg to a milestone
     *
     * @return mixed
     */
    public function viewMilestoneResourcesAction()
    {
        $em = $this->entityManager;
        $modal = new WasabiModal("standard");
        $response = new Response();
        $id = $this->params()->fromQuery("data", NULL);
        
        $repo = $em->getRepository(TrainingMilestoneResources::class);
        $data = $repo->createQueryBuilder("s")
            ->select([
            "s",
            "i"
        ])
            ->leftJoin("s.document", "i")
            ->where("s.milestone = :milestone")
            ->setParameters([
            "milestone" => $id
        ])
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        $viewModel = new ViewModel([
            "data" => $data
        ]);
        
        $viewModel->setTemplate("training-milestone-resources-list-snippet");
        $modal->setContent($viewModel);
        $modalView = new WasabiModalView("#wasabi", $this->renderer, $modal);
        $response->add($modalView);
        return $this->getResponse()->setContent($response);
    }

    /**
     * Used to retrieve the submit statis of a UserTraining Entity
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function getUserTrainingSubmitStatusAction()
    {
        $jsonModel = new JsonModel();
        $id = $this->params()->fromRoute("id", NULL);
        $em = $this->entityManager;
        $user = $this->identity();
        
        $data = $em->getRepository(UserTraining::class)->findOneBy([
            "training" => $id,
            "user" => $user->getId()
        ]);
        
        $res = ($data->getSubmitStatus() == NULL ? FALSE : [
            'id' => $data->getSubmitStatus()->getId(),
            "status" => $data->getSubmitStatus()->getStatus()
        ]);
        // var_dump($res);
        $jsonModel->setVariables([
            "data" => $res
        ]);
        // $jsonModel->setStatusCode(200);
        return $jsonModel;
    }

    /**
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function postAssignmentAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $user = $this->identity();
        $response = new Response();
        $request = $this->getRequest();
        // $submmitedTrainingEntity = new Usersubmitte
        if ($request->isPost()) {
            
            $post = $this->params()->fromPost();
            
            // var_dump($request->getHeader('referer')->uri()->toString());
            try {
                $trainingId = $post['submitMilestoneAnswerFieldset']["trainingId"];
                $userTrainingEntity = $em->getRepository(UserTraining::class)->findOneBy([
                    "user" => $user->getId(),
                    "training" => $trainingId
                ]);
                
                /**
                 *
                 * @var UserSubmittedTrainingAssignment $milestone
                 */
                $milestone = $post['submitMilestoneAnswerFieldset']['milestone'];
                $submittedEntity = $em->getRepository(UserSubmittedTrainingAssignment::class)->findOneBy([
                    "userTraining" => $userTrainingEntity->getId(),
                    "milestone" => $milestone
                ]);
                
                if ($submittedEntity == NULL) {
                    $submittedEntity = new UserSubmittedTrainingAssignment();
                    $submittedEntity->setCreatedOn(new \DateTime())
                        ->setMilestone($em->find(TrainingAssigmentMilestone::class, $milestone))
                        ->setUserTraining($userTrainingEntity);
                }
                
                $content = $post['submitMilestoneAnswerFieldset']["answerss"];
                
                $encodedContent = base64_encode($content);
                
                $submittedEntity->setAnswerss($encodedContent)->setUpdatedOn(new \DateTime());
                
                $em->persist($submittedEntity);
                
                $em->flush();
                $redirect = new Redirect($request->getHeader('referer')
                    ->uri()
                    ->toString());
                
                $this->flashMessenger()->addSuccessMessage("Milestone answer successfully submitted");
                $response->add($redirect);
                
                // /**
                // * Send email to user
                // */
                // $generalService = $this->generalService;
                
                // $pointer["to"] = $user->getEmail();
                // $pointer["fromName"] = GeneralService::APP_COMPANY_NAME;
                // $pointer['subject'] = "Tfits Entrepreneur Journey";
                
                // $template['template'] = "training-submitted-milestone-email";
                // $template["var"] = [
                // "logo" => $this->url()->fromRoute('home', array(), array(
                // 'force_canonical' => true
                // )) . "img/logo.png"
                
                // ];
                // $generalService->sendMails($pointer, $template);
            } catch (\Exception $e) {
                $gritter = new GritterMessage();
                $gritter->setType(GritterMessage::TYPE_ERROR);
                $gritter->setTitle("IDENTIFIER ERROR");
                $gritter->setTime(10000);
                $gritter->setText($e->getLine());
                $response->add($gritter);
            }
        }
        return $this->getResponse()->setContent($response);
    }

    public function submitUserTrainingAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $em = $this->entityManager;
        $user = $this->identity();
        $generalService = $this->generalService;
        if ($request->isPost()) {
            $post = $request->getPost();
            $id = $post["trainingId"];
            /**
             *
             * @var UserTraining $userTrainingEntity;
             */
            $userTrainingEntity = $em->find(UserTraining::class, $id);
            $userTrainingEntity->setSubmitStatus($em->find(UserTrainingSubmitStatus::class, TrainingService::USER_TRAINING_SUBMIT_STATUS_SUBMITED));
            try {
                
                $userTrainingActivityEntity = new UserTrainingActivity();
                $userTrainingActivityEntity->setCreatedOn(new \DateTime())
                    ->setActivity("Submitted Trfaining")
                    ->setUserraining($userTrainingEntity);
                
                $em->persist($userTrainingEntity);
                $em->persist($userTrainingActivityEntity);
                
                $generalService = $this->generalService;
                
                $pointer["to"] = $user->getEmail();
                $pointer["fromName"] = GeneralService::APP_COMPANY_NAME;
                $pointer['subject'] = "Tfits Entrepreneur Journey";
                
                $template['template'] = "training-submitted-milestone-email";
                $template["var"] = [
                    "logo" => $this->url()->fromRoute('home', array(), array(
                        'force_canonical' => true
                    )) . "img/logo.png"
                
                ];
                $generalService->sendMails($pointer, $template);
                $em->flush();
                
                $jsonModel->setVariables([
                    "data" => ""
                ]);
                $response->setStatusCode(201);
                // send mail of successfully submitting training
            } catch (\Exception $e) {
                $jsonModel->setVariables([
                    "messages" => "Something went wrong"
                ]);
                $response->setStatusCode(401);
            }
        }
        return $jsonModel;
    }

    public function getAllPublishedTrainingAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $em = $this->entityManager;
        $repo = $em->getRepository(Training::class);
        $data = $repo->createQueryBuilder("t")
            ->select([
            "t",
            "p",
            "i"
        ])
            ->leftJoin("t.programmes", "p")
            ->leftJoin("t.image", "i")
            ->where("t.isPublished = :pub")
            ->setParameters([
            "pub" => TRUE
        ])
            ->setMaxResults(10)
            ->orderBy("t.updatedOn", "DESC")
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        $jsonModel->setVariables([
            "data" => $data
        ]);
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Access-Control-Allow-Origin', '*');
        $response->getHeaders()->addHeaderLine('Access-Control-Allow-Credentials', 'true');
        $response->getHeaders()->addHeaderLine('Access-Control-Allow-Methods', 'POST PUT DELETE GET');
        
        return $jsonModel;
    }

    public function countTotalTrainingAction()
    {
        return new JsonModel(array(
            "count" => $this->trainingService->countTotalTraining()
        ));
    }

    public function countTotalProgrammesAction()
    {
        return new JsonModel(array(
            "count" => $this->trainingService->countTotalProgrammes()
        ));
    }

    public function countTotalCourseAction()
    {
        return new JsonModel(array(
            "count" => $this->trainingService->countTotalCourse()
        ));
    }

    public function countInProgressAction()
    {
        return new JsonModel(array(
            "count" => $this->trainingService->countTotalTrainingInProgress()
        ));
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
     * @return the $trainingService
     */
    public function getTrainingService()
    {
        return $this->trainingService;
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
     * @param \Training\Service\TrainingService $trainingService            
     */
    public function setTrainingService($trainingService)
    {
        $this->trainingService = $trainingService;
        return $this;
    }

    /**
     *
     * @param field_type $showAssignmentForm            
     */
    public function setShowAssignmentForm($showAssignmentForm)
    {
        $this->showAssignmentForm = $showAssignmentForm;
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
}

