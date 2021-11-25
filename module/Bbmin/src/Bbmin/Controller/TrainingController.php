<?php
namespace Bbmin\Controller;

use Bbmin\Entity\AdminSubmittedAssignment;
use Doctrine\ORM\EntityManager;
use General\Paginator\PaginatorAdapter;
use General\Service\GeneralService;
use General\Service\UploadService;
use Laminas\Http\Response;
use Laminas\InputFilter\InputFilter;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Session\Container;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;
use Training\Entity\Programmes;
use Training\Entity\Training;
use Training\Entity\TrainingActivation;
use Training\Service\ProgrammesService;
use Training\Service\TrainingService;
use WasabiLib\Ajax\GritterMessage;
use WasabiLib\Ajax\Redirect;

/**
 *
 * @author otaba
 *
 */
class TrainingController extends AbstractActionController
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var Container
     */
    private $trainingSession;

    /**
     *
     * @var TrainingService
     */
    private $trainingService;

    /**
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     *
     * @var UploadService
     */
    private $uploadService;

    private $trainingPaginator;

    /**
     *
     * @var PaginatorAdapter
     */
    private $paginator;

    /**
     */
    public function __construct()
    {

        // TODO - Insert your code here
    }

    public function createAction()
    {
        $trainingSession = $this->trainingSession;
        // Restart Training Session
        // Clear old one
        // Start new session

        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function viewAction()
    {
        $trainings = $this->trainingPaginator;

        $viewModel = new ViewModel(array(
            "trainings" => $trainings,
        ));
        return $viewModel;
    }

    public function premanageAction()
    {
        $response = new \WasabiLib\Ajax\Response();
        $trainingService = $this->trainingService;
        $id = $this->params()->fromQuery("data");
        if ($id !== null) {
            $trainingSession = $trainingService->getTrainingManagementSession();
            $trainingSession->id = strip_tags($id);

            $redirect = new Redirect($this->url()->fromRoute("bbmintraining/default", array(
                "action" => "manage",
            )));
            $response->add($redirect);
        } else {
            $gritter = new GritterMessage();
            $gritter->setType(GritterMessage::TYPE_ERROR);
            $gritter->setText("Absent Identifier");
            $gritter->setTitle("Error");

            $response->add($gritter);
        }
        return $this->getResponse()->setContent($response);
    }

    public function manageAction()
    {
        $em = $this->entityManager;
        $trainingSession = $this->trainingService->getTrainingManagementSession();
        $trainingUid = $trainingSession->id;
        if ($trainingUid == null) {
            $this->flashmessenger()->addErrorMessage("Absent Identifier");
            return $this->redirect()->toRoute("bbmintraining/default", array(
                "action" => "view",
            ));
        }
        $training = $em->getRepository(Training::class)->findOneBy([
            "trainingUid" => $trainingUid,
        ]);
        $activation = $em->getRepository(TrainingActivation::class)->findBy([
            "training" => $training->getId(),
        ], [
            "id" => "DESC",
        ]);
        $viewModel = new ViewModel(array(
            "training" => $training,
            "activation" => $activation,
        ));
        return $viewModel;
    }

    public function createTrainingAction()
    {
        $em = $this->entityManager;
        $trainingSession = $this->trainingSession;
        $trainingSession = $this->trainingService->getTrainingManagementSession();
        $request = $this->getRequest();
        $jsonModel = new JsonModel();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $files = $request->getFiles()->toArray();
            $merge = array_merge($post, $files);

            $inputFilter = new InputFilter();
            $inputFilter->add(array(
                'name' => 'topic',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags',
                    ),
                    array(
                        'name' => 'StringTrim',
                    ),
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'First name is required',
                            ),
                        ),
                    ),
                ),
            ));
            $inputFilter->add(array(
                'name' => 'points',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags',
                    ),
                    array(
                        'name' => 'StringTrim',
                    ),
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Points is required',
                            ),
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'desc',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags',
                    ),
                    array(
                        'name' => 'StringTrim',
                    ),
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'First name is required',
                            ),
                        ),
                    ),
                ),
            ));
            $inputFilter->setData($post);
            if ($inputFilter->isValid()) {
                $data = $inputFilter->getValues();

                try {

                    $imageEntity = $this->uploadService->upload($merge["file"]);

                    $trainingTopic = $data["topic"];
                    $trainingDescription = $data["desc"];
                    $trainingPoints = $data['points'];
                    $trainingEntity = new Training();
                    $trainingEntity->setCreatedOn(new \DateTime())
                        ->setTrainingUid(TrainingService::generateTrainingUid())
                        ->setImage($imageEntity)
                        ->setIsPublished(false)
                        ->setTrainingPoints($trainingPoints)
                        ->setTrainingTopic($trainingTopic)
                        ->setTrainingDescription($trainingDescription);
                    // var_dump($imageEntity);
                    $em->persist($imageEntity);
                    $em->persist($trainingEntity);

                    $em->flush();

                    $trainingSession->trainingId = $trainingEntity->getId();
                    $trainingSession->id = $trainingEntity->getTrainingUid();
                    $this->getResponse()->setStatusCode(Response::STATUS_CODE_201);
                    $jsonModel->setVariables(array(
                        "success" => true,
                        "topic" => $trainingEntity->getTrainingTopic(),
                        "uid" => $trainingEntity->getTrainingUid(),
                        "description" => $trainingEntity->getTrainingDescription(),
                        "banner" => $trainingEntity->getImage()
                            ->getImageUrl(),
                    ));
                } catch (\Exception $e) {
                    $this->getResponse()->setStatusCode(Response::STATUS_CODE_200);
                    $jsonModel->setVariables(array(
                        "error" => "Hydration Error",
                        "data" => $e->getMessage(),

                        "dat" => $e->getTrace(),
                    ));
                }
            } else {
                $this->getResponse()->setStatusCode(Response::STATUS_CODE_200);
                $jsonModel->setVariables(array(

                    "error" => $inputFilter->getMessages(),
                ));
            }
        }

        return $jsonModel;
    }

    public function createProgrammesAction()
    {
        $em = $this->entityManager;
        $trainingId = $this->trainingSession->trainingId;
        $trainingEntity = $em->find(Training::class, $trainingId);
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            $inputFilter = new InputFilter();
            $inputFilter->add(array(
                'name' => 'topic',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags',
                    ),
                    array(
                        'name' => 'StringTrim',
                    ),
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'First name is required',
                            ),
                        ),
                    ),
                ),
            ));
            $inputFilter->add(array(
                'name' => 'description',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags',
                    ),
                    array(
                        'name' => 'StringTrim',
                    ),
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'First name is required',
                            ),
                        ),
                    ),
                ),
            ));
            $inputFilter->setData($post);
            if ($inputFilter->isValid()) {
                $data = $inputFilter->getValues();
                try {
                    $programeEntity = new Programmes();
                    $programeEntity->setCreatedOn(new \DateTime())
                        ->setDescription($data["description"])
                        ->setTitle($data["title"])
                        ->setProgrammesUid(ProgrammesService::generateProgrammesUid())
                        ->setTraining($em->find(Training::class, $trainingId));

                    $em->persist($programeEntity);
                    $em->flush();

                    $this->getResponse()->setStatusCode(Response::STATUS_CODE_201);
                    $jsonModel->setVariables(array(
                        "data" => array(
                            "uid" => $programeEntity->getProgrammesUid(),
                            "title" => $programeEntity->getTitle(),
                            "description" => $programeEntity->getDescription(),
                            "id" => $programeEntity->getId(),
                        ),
                    ));
                } catch (\Exception $e) {
                    $this->getResponse()->setStatusCode(Response::STATUS_CODE_200);
                    $jsonModel->setVariables([
                        "error" => "Hydrtation Error",
                    ]);
                }
            } else {
                $this->getResponse()->setStatusCode(Response::STATUS_CODE_200);
                $jsonModel->setVariables(array(
                    "error" => $inputFilter->getMessages(),
                ));
            }
        }
        return $jsonModel;
    }

    /**
     * Get submitted assigments
     *
     * @return \Laminas\View\Model\ViewModel
     */
    public function assignmentsAction()
    {
        $viewModel = new ViewModel();
        $pageCount = $this->params()->fromRoute("pcount", null) ?? 20;
        $pageNumber = $this->params()->fromRoute("page", null) ?? 1;
        $em = $this->entityManager;
        $query = $em->getRepository(AdminSubmittedAssignment::class)->findInitiatedAssignment();
        $paginator = $this->paginator;
        $assignmentStage = $this->params()->fromQuery("stage");
        if ($assignmentStage == "disbursed") {
            $query = $em->getRepository(AdminSubmittedAssignment::class)->findDisbursedAssignment();
        } elseif ($assignmentStage == "completed") {
            $query = $em->getRepository(AdminSubmittedAssignment::class)->findCompletedAssignment();
        } elseif ($assignmentStage == "processing") {
            $query = $em->getRepository(AdminSubmittedAssignment::class)->findProcessingAssignment();
        }
        $paginator = $this->paginator->setQuery($query)->createPaginator();
        $paginator->setDefaultItemCountPerPage($pageCount);
        $paginator->setCurrentPageNumber($pageNumber);
        // var_dump($paginator);
        $viewModel->setVariables([
            "trainings" => $paginator,
        ]);
        return $viewModel;
    }

    public function manageSubmittedTrainingAction()
    {
        $request = $this->getRequest();
        $viewModel = new ViewModel();
        $em = $this->entityManager;
        $id = $this->params()->fromRoute("id", null);
        if ($id !== null) {
            $submittedTraining = $em->find(AdminSubmittedAssignment::class, $id);
            $viewModel->setVariables([
                "submitted" => $submittedTraining,
            ]);
        }

        return $viewModel;
    }

    public function createCoursesAction()
    {
        $jsonModel = new JsonModel();

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
     * @param \Laminas\Session\Container $trainingSession
     */
    public function setTrainingSession($trainingSession)
    {
        $this->trainingSession = $trainingSession;
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
     * @param \General\Service\GeneralService $generalService
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return $this;
    }

    /**
     *
     * @param \General\Service\UploadService $uploadService
     */
    public function setUploadService($uploadService)
    {
        $this->uploadService = $uploadService;
        return $this;
    }

    /**
     *
     * @return the $trainingPaginator
     */
    public function getTrainingPaginator()
    {
        return $this->trainingPaginator;
    }

    /**
     *
     * @param field_type $trainingPaginator
     */
    public function setTrainingPaginator($trainingPaginator)
    {
        $this->trainingPaginator = $trainingPaginator;
        return $this;
    }

    /**
     *
     * @param field_type $paginator
     */
    public function setPaginator($paginator)
    {
        $this->paginator = $paginator;
        return $this;
    }
}
