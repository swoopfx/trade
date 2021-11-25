<?php
namespace Bbmin\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;
use Training\Service\TrainingService;
use General\Service\GeneralService;
use Training\Entity\Training;
use Laminas\Http\Response;
use Training\Entity\Programmes;
use Laminas\InputFilter\InputFilter;
use Training\Service\ProgrammesService;
use Training\Entity\Course;
use DoctrineModule\Validator\NoObjectExists;
use Training\Service\CourseService;
use WasabiLib\Modal\WasabiModal;
use Laminas\View\Model\ViewModel;
use WasabiLib\Modal\WasabiModalView;
use Training\Form\CourseForm;
use Training\Entity\TrainingAssigmentMilestone;
use Doctrine\ORM\Query;
use Laminas\Session\Container;
use General\Service\UploadService;
use Training\Entity\TrainingActivation;
use Training\Entity\TrainingMilestoneResources;

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

    /**
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     *
     * @var ProgrammesService
     */
    private $programmesService;

    /**
     *
     * @var unknow
     */
    private $renderer;

    // Forms
    private $createCourseForm;

    /**
     *
     * @var CourseForm
     */
    private $courseForm;

    /**
     *
     * @var UploadService
     */
    private $uploadService;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function indexAction()
    {
        // return new JsonModel(array(
        // "sert"
        // ));
    }

    public function testAction()
    {
        $response = new \WasabiLib\Ajax\Response();
        $modal = new WasabiModal("standard");
        
        $modalView = new WasabiModalView("#wasabi", $this->renderer, $modal);
        $response->add($modalView);
        return $this->getResponse()->setContent($response);
    }

    /**
     * Creates a new activation for a training while it deactivates all availaible active activation
     * @return \Laminas\View\Model\JsonModel
     */
    public function createTrainingActivationAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $response = $this->getResponse();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            $trainingId = $post["trainingId"];
            try {
                $activtionEntity = $em->getRepository(TrainingActivation::class)->findBy([
                    "training" => $trainingId
                ]);
                
                if ($activtionEntity != NULL) {
                    foreach ($activtionEntity as $activation) {
                        $activation->setIsActive(FALSE);
                        $em->persist($activation);
                    }
                }
                
                // var_dump($post);
                
                $newEntity = new TrainingActivation();
                $newEntity->setCreatedOn(new \DateTime())
                    ->setIsActive(TRUE)
                    ->setMaximumCount($post["maximumCount"])
                    ->setTraining($em->find(Training::class, $trainingId))
                    ->setStartdate(\DateTime::createFromFormat("Y-m-d", $post['startdate']))
                    ->setEnddate(\DateTime::createFromFormat("Y-m-d", $post['enddate']))
                    ->setUsersAwardedCount(0);
                
                $em->persist($newEntity);
                $em->flush();
                
                $response->setStatusCode(201);
                $jsonModel->setVariables([]);
            } catch (\Exception $e) {
                $response->setStatusCode(400);
                
                $jsonModel->setVariables([
                    "messages"=>"Something went wrong please try again latter",
                    'data'=>$e->getMessage()
                ]);
            }
        }
        return $jsonModel;
    }
    
    
    public function deactivateActivationAction(){
        $jsonModel = new  JsonModel();
        $request = $this->getRequest();
        $em = $this->entityManager;
        $response = $this->getResponse();
        if($request->isPost()){
            $post = $request->getPost();
            $acivationId = $post["activationId"];
            /**
             * 
             * @var TrainingActivation $activationEntity
             */
            $activationEntity = $em->find(TrainingActivation::class, $acivationId);
            $activationEntity->setIsActive(FALSE);
            
            $em->persist($activationEntity);
            $em->flush();
            
            $response->setStatusCode(204);
        }
        return $jsonModel;
    }

    public function updateTrainingAction()
    {
        $em = $this->entityManager;
        
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $trainingManagementSerssion = $this->trainingService->getTrainingManagementSession();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $inputFilter = new InputFilter();
            $inputFilter->add(array(
                'name' => 'topic',
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
                                'isEmpty' => 'First name is required'
                            )
                        )
                    )
                )
            ));
            $inputFilter->add(array(
                'name' => 'desc',
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
                                'isEmpty' => 'First name is required'
                            )
                        )
                    )
                )
            ));
            
            $inputFilter->add(array(
                'name' => 'points',
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
                                'isEmpty' => 'First name is required'
                            )
                        )
                    )
                )
            ));
            $inputFilter->setData($post);
            if ($inputFilter->isValid()) {
                $data = $inputFilter->getValues();
                
                /**
                 *
                 * @var Training $trainingEntity
                 */
                $trainingEntity = $em->getRepository(Training::class)->findOneBy([
                    "trainingUid" => $trainingManagementSerssion->id
                ]);
                if ($trainingEntity != NULL) {
                    try {
                        $trainingEntity->setTrainingTopic($data["topic"])
                            ->setTrainingDescription($data["desc"])
                            ->setTrainingPoints($data["points"])
                            ->setUpdatedOn(new \DateTime());
                        
                        $em->persist($trainingEntity);
                        $em->flush();
                        
                        $response->setStatusCode(Response::STATUS_CODE_201);
                    } catch (\Exception $e) {
                        $response->setStatusCode(Response::STATUS_CODE_599);
                        $jsonModel->setVariables([
                            "message" => "Hydration Error"
                        ]);
                    }
                }
            } else {
                $response->setStatusCode(Response::STATUS_CODE_422);
                $message = $inputFilter->getMessages();
                $jsonModel->setVariables(array(
                    "message" => $message[0]
                ));
            }
        } else {
            $response->setStatusCode(Response::STATUS_CODE_403);
            $jsonModel->setVariables(array(
                "message" => "Absent Identifier"
            ));
        }
        return $jsonModel;
    }

    public function gettrainingAction()
    {
        $em = $this->entityManager;
        $trainingManagementSession = $this->trainingService->getTrainingManagementSession();
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        if ($trainingManagementSession->id != NULL) {
            $trainingArray = $this->trainingService->getTrainingByUid(strip_tags($trainingManagementSession->id));
            $response->setStatusCode(Response::STATUS_CODE_200);
            $jsonModel->setVariables(array(
                "data" => $trainingArray
            ));
        } else {
            $response->setStatusCode(Response::STATUS_CODE_403);
            $jsonModel->setVariables(array(
                "message" => "Absent Identifier"
            ));
        }
        
        return $jsonModel;
    }

    public function createprogramAction()
    {
        $em = $this->entityManager;
        $trainingManagementSession = $this->trainingService->getTrainingManagementSession();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $jsonModel = new JsonModel();
        if ($trainingManagementSession != NULL) {
            if ($request->isPost()) {
                $programmesEntity = new Programmes();
                $post = $request->getPost()->toArray();
                $inputFilter = new InputFilter();
                $inputFilter->add(array(
                    'name' => 'title',
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
                                    'isEmpty' => 'Topic is required'
                                )
                            )
                        )
                    )
                ));
                $inputFilter->add(array(
                    'name' => 'description',
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
                                    'isEmpty' => 'Description is required'
                                )
                            )
                        )
                    )
                ));
                $inputFilter->setData($post);
                if ($inputFilter->isValid()) {
                    $data = $inputFilter->getValues();
                    
                    $programmesEntity->setCreatedOn(new \DateTime())
                        ->setDescription($data["description"])
                        ->setProgrammesUid(ProgrammesService::generateProgrammesUid())
                        ->setTitle($data["title"])
                        ->setTraining($em->getRepository(Training::class)
                        ->findOneBy([
                        "trainingUid" => $trainingManagementSession->id
                    ]));
                    
                    $em->persist($programmesEntity);
                    $em->flush();
                    
                    $response->setStatusCode(Response::STATUS_CODE_201);
                    $jsonModel->setVariables(array());
                } else {
                    $response->setStatusCode(Response::STATUS_CODE_422);
                    $message = $inputFilter->getMessages();
                    $jsonModel->setVariables(array(
                        "message" => $message[0]
                    ));
                }
            } else {
                $response->setStatusCode(Response::STATUS_CODE_403);
                $jsonModel->setVariables(array(
                    "message" => "Not authorized"
                ));
            }
        } else {
            $response->setStatusCode(Response::STATUS_CODE_422);
            $jsonModel->setVariables(array(
                "message" => "Absent Identifier, Please"
            ));
        }
        
        return $jsonModel;
    }

    public function editprogrammeAction()
    {
        $em = $this->entityManager;
        $jsonModel = new JsonModel();
        $progrmaessUid = $this->params()->fromRoute("id", NULL);
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($progrmaessUid != NULL) {
            /**
             *
             * @var Programmes $programmesEntity
             */
            $programmesEntity = $em->getRepository(Programmes::class)->findOneBy([
                "programmesUid" => $progrmaessUid
            ]);
            if ($request->isPost()) {
                $post = $request->getPost()->toArray();
                $inputFiler = new InputFilter();
                if ($inputFiler->isValid()) {}
            } else {
                $response->setStatusCode(Response::STATUS_CODE_403);
                $jsonModel->setVariables(array(
                    "message" => "Not authorized"
                ));
            }
        }
        
        return $jsonModel;
    }

    public function removeprogrammesAction()
    {}

    public function getprogrammesAction()
    {
        $em = $this->entityManager;
        $trainingManagementSession = $this->trainingService->getTrainingManagementSession();
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        if ($trainingManagementSession->id != NULL) {
            $uid = strip_tags($trainingManagementSession->id);
            // get Programmes Related to this training Id
            
            $trainingEntity = $em->getRepository(Training::class)->findOneBy([
                "trainingUid" => $uid
            ]);
            $programmesArray = $this->programmesService->getProgrammesByTrainingId($trainingEntity->getId());
            
            $response->setStatusCode(Response::STATUS_CODE_200);
            $jsonModel->setVariables(array(
                "programmes" => $programmesArray
            ));
        } else {
            $jsonModel->setStatusCode(Response::STATUS_CODE_403);
            $jsonModel->setVariables(array(
                "message" => "Absent Training Identifier"
            ));
        }
        
        return $jsonModel;
    }

    public function createCourseAction()
    {
        $em = $this->entityManager;
        // $programmesUid = $this->params()->fromRoute("programmeuid");
        $request = $this->getRequest();
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $inputFilter = new InputFilter();
            
            $inputFilter->add(array(
                'name' => 'title',
                'required' => true,
                "allow_empty" => false,
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
                                'isEmpty' => 'Title is required'
                            )
                        )
                    )
                )
            ));
            $inputFilter->add(array(
                'name' => 'code',
                'required' => true,
                "allow_empty" => false,
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
                                'isEmpty' => 'Course Code is required'
                            )
                        )
                    ),
                    array(
                        'name' => 'DoctrineModule\Validator\NoObjectExists',
                        'options' => array(
                            'use_context' => true,
                            'object_repository' => $this->entityManager->getRepository(Course::class),
                            'object_manager' => $this->entityManager,
                            'fields' => array(
                                'courseCode'
                            ),
                            'messages' => array(
                                
                                NoObjectExists::ERROR_OBJECT_FOUND => 'Please choose another Code, for this course'
                            )
                        )
                    )
                )
            ));
            $inputFilter->add(array(
                'name' => 'video',
                'required' => true,
                "allow_empty" => false,
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
                                'isEmpty' => 'Video Link is required'
                            )
                        )
                    )
                    // array(
                    // "name" => "url",
                    // "options" => array(
                    // "allowRelative" => false
                    // )
                    // )
                )
            ));
            $inputFilter->setData($post);
            if ($inputFilter->isValid()) {
                
                $data = $inputFilter->getValues();
                
                try {
                    $courseEntity = new Course();
                    $courseEntity->setCourseCode($data["code"])
                        ->setTitle($data["title"])
                        ->setCourseUid(CourseService::generateCourseUid())
                        ->setVideo($data["video"])
                        ->setCreatedOn(new \DateTime())
                        ->setIsActive(TRUE)
                        ->setProgammes($em->find(Programmes::class, $post["pid"]));
                    
                    $em->persist($courseEntity);
                    $em->flush();
                    
                    $response->setStatusCode(Response::STATUS_CODE_201);
                    $jsonModel->setVariables(array(
                        "courseCode" => $courseEntity->getCourseCode(),
                        "courseUid" => $courseEntity->getCourseUid()
                    
                    ));
                    return $jsonModel;
                } catch (\Exception $e) {
                    $response->setStatusCode(Response::STATUS_CODE_422);
                    $jsonModel->setVariables(array(
                        "message" => $inputFilter->getMessages()[0]
                    ));
                    return $jsonModel;
                }
            } else {
                $response->setStatusCode(Response::STATUS_CODE_433);
                $jsonModel->setVariables(array(
                    "message" => $inputFilter->getMessages()[0]
                ));
                return $jsonModel;
            }
        } else {
            $response->setStatusCode(Response::STATUS_CODE_403);
            $jsonModel->setVariables(array(
                "message" => "Not authorized"
            ));
            return $jsonModel;
        }
        
        $response->setStatusCode(Response::STATUS_CODE_500);
        return $jsonModel;
    }

    public function viewcourseAction()
    {
        $jsonmodel = new JsonModel();
        $response = $this->getResponse();
        $em = $this->entityManager;
        $uid = $this->params()->fromRoute("id", NULL);
        
        if ($uid != NULL) {
            /**
             *
             * @var Course $courseEntity
             */
            $courseEntity = $em->getRepository(Course::class)->findOneBy([
                "courseUid" => $uid
            ]);
            
            $response->setStatusCode(200);
            $jsonmodel->setVariables([
                "course" => $courseEntity->getVideo(),
                "title" => $courseEntity->getTitle()
            ]);
        } else {
            $response->setStatusCode(500);
            $jsonmodel->setVariables([
                "messages" => "We could not get the specific course"
            ]);
        }
        return $jsonmodel;
    }

    public function showcreatecourseformAction()
    {
        // $courseForm = $this->courseForm;
        // $response = new \WasabiLib\Ajax\Response();
        // $modal = new WasabiModal("standard");
        // // $viewModel = new ViewModel();
        // // $viewModel->setVariables(array(
        // // "form"=>$courseForm
        // // ));
        // // $viewModel->setTemplate("course_form_snippet");
        // // $modal->setContent($viewModel);
        // $modalView = new WasabiModalView("#wasabi", $this->renderer, $modal);
        // $response->add($modalView);
        return new JsonModel(array(
            "2"
        ));
        return $this->getResponse()->setContent($response);
    }

    public function getcourseAction()
    {
        $em = $this->entityManager;
        $jsonModel = new JsonModel();
        $programeUid = $this->params()->fromQuery("id");
        $response = $this->getResponse();
        if ($programeUid != NULL) {
            $uid = strip_tags($programeUid);
            /**
             *
             * @var Programmes $programmesEntity
             */
            $programmesEntity = $em->getRepository(Programmes::class)->findOneBy([
                "programmesUid" => $uid
            ]);
            $coursesCollection = $programmesEntity->getCourse()->toArray();
            $response->setStatusCode(Response::STATUS_CODE_200);
            $jsonModel->setVariables(array(
                "courses" => $coursesCollection
            ));
        } else {
            $response->setStatusCode(Response::STATUS_CODE_422);
            $jsonModel->setVariables(array(
                "message" => "Absent Identifier"
            ));
        }
        
        return $jsonModel;
    }

    // public function viewcourseAction()
    // {
    // $em = $this->entityManager;
    // $jsonModel = new JsonModel();
    // $response = $this->getResponse();
    // $request = $this->getRequest();
    // $uid = $this->params()->fromQuery("uid", NULL);
    // if ($uid != NULL) {
    // $data = $em->getRepository(Course::class)->findCourseByUid(strip_tags($uid));
    // $response->setStatusCode(Response::STATUS_CODE_200);
    // $jsonModel->setVariables([
    // "data" => $data
    // ]);
    // } else {
    // $response->setStatusCode(Response::STATUS_CODE_403);
    // $jsonModel->setVariables([
    // "message" => "Identifier Absent"
    // ]);
    // }
    // return $jsonModel;
    // }
    public function publishtrainingAction()
    {
        $em = $this->entityManager;
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $id = $this->params()->fromPost("trainingId", NULL);
            $state = (int) $this->params()->fromPost("state", NULL);
            if ($id == NULL) {
                $response->setStatusCode(200);
                $jsonModel->setVariables([
                    "isNull" => TRUE,
                    "messages" => "Identifier is absent"
                ]);
            } else {
                try {
                    /**
                     *
                     * @var Training $trainingEntity
                     */
                    $trainingEntity = $em->find(Training::class, $id);
                    $trainingEntity->setIsPublished($state)->setUpdatedOn(new \DateTime());
                    
                    $em->persist($trainingEntity);
                    $em->flush();
                    
                    $this->flashmessenger()->addSuccessMessage("Successfully Changed Publish State");
                    $response->setStatusCode(201);
                } catch (\Exception $e) {
                    $response->setStatusCode(400);
                    $jsonModel->setVariables([
                        "messages" => "Training state could not be changed"
                    ]);
                }
            }
        }
        return $jsonModel;
    }

    /**
     * returns an array of milestones
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function getmilestonesAction()
    {
        $jsonModel = new JsonModel();
        $id = $this->params()->fromRoute("id", NULL);
        $response = $this->getResponse();
        $em = $this->entityManager;
        $repo = $em->getRepository(TrainingAssigmentMilestone::class);
        
        $data = $repo->createQueryBuilder("m")
            ->select([
            'm',
            'r'
        ])
            ->leftJoin("m.milestoneReources", "r")
            ->where("m.training = :trainingid")
            ->setParameters([
            'trainingid' => $id
        ])
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        // var_dump("LLLL");
        $response->setStatusCode(200);
        $jsonModel->setVariables([
            "data" => $data
        ]);
        return $jsonModel;
    }

    /**
     * Geta a single milestone from its ID
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function getmilestonebyidAction()
    {
        $response = $this->getResponse();
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $id = $this->params()->fromRoute("id", NULL);
        $response->setStatusCode(200);
        
        $repo = $em->getRepository(TrainingAssigmentMilestone::class);
        $data = $repo->createQueryBuilder("m")
            ->select([
            'm'
        ])
            ->where("m.id = :id")
            ->setParameters([
            'id' => $id
        ])
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        $jsonModel->setVariables([
            "data" => $data[0]
        ]);
        return $jsonModel;
    }

    public function postmilestoneAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $em = $this->entityManager;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            try {
                
                $encodedContent = $post['content'];
                $topic = strip_tags($post['topic']);
                $description = strip_tags($post['desc']);
                $trainigEntity = $em->find(Training::class, $post["trainingid"]);
                $milestoneEntity = new TrainingAssigmentMilestone();
                $milestoneEntity->setContent($encodedContent)
                    ->setCreatedOn(new \DateTime())
                    ->setDescriptions($description)
                    ->setMilestoneUid(uniqid("ms"))
                    ->setTopic($topic)
                    ->setTraining($trainigEntity);
                
                $em->persist($milestoneEntity);
                $em->flush();
                
                $this->flashmessenger()->addSuccessMessage("Hooray!! Milestone Successfully created");
                $response->setStatusCode(201);
            } catch (\Exception $e) {
                $response->setStatusCode(422);
                $jsonModel->setVariables([
                    "messages" => "Something went wrong, please try againlater",
                    "data" => $e->getTraceAsString()
                ]);
            }
        } else {
            $response->setStatusCode(401);
            $jsonModel->setVariables([
                "messages" => "Not Authorized"
            ]);
        }
        $jsonModel->setVariables([]);
        return $jsonModel;
    }

    public function initiateuploadsessionAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post = $request->getPost();
            $uploadSession = new Container("initiate_upload_session");
            $uploadSession->id = $post['id'];
            $response->setStatusCode(202);
        }
        return $jsonModel;
    }

    /**
     * Uploads a resources to a specific milestone
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function uploadmilestoneresourcesAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $uploadSession = new Container("initiate_upload_session");
        $em = $this->entityManager;
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            $files = $request->getFiles()->toArray();
            
            try {
                $milestoneEntity = $em->find(TrainingAssigmentMilestone::class, $uploadSession->id);
                
                $imageEntity = $this->uploadService->upload($files["document"]);
                
                $milestoneResourcesEntity = new TrainingMilestoneResources();
                $milestoneResourcesEntity->setCreatedOn(new \DateTime())
                    ->setDocument($imageEntity)
                    ->setMilestone($milestoneEntity)
                    ->setName(strip_tags($post["name"]));
                
                $em->persist($imageEntity);
                $em->persist($milestoneResourcesEntity);
                
                $em->flush();
                $response->setStatusCode(201);
            } catch (\Exception $e) {
                $response->setStatusCode(422);
                $jsonModel->setVariables([
                    'messages' => $e->getMessage(),
                    'data' => $e->getTraceAsString()
                ]);
            }
        }
        return $jsonModel;
    }

    /**
     * Gets a list of resources attached to a specific milestone
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function getMilestoneResourceAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        
        $request = $this->getRequest();
        $id = $this->params()->fromRoute("id", NULL);
        $repo = $em->getRepository(TrainingMilestoneResources::class);
        $data = $repo->createQueryBuilder("r")
            ->select([
            "r",
            "d",
            "m"
        ])
            ->leftJoin("r.document", "d")
            ->leftJoin("r.milestone", "m")
            ->where("r.milestone = :milestone")
            ->setParameters([
            "milestone" => $id
        ])
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        
        $jsonModel->setVariables([
            "data" => $data
        ]);
        return $jsonModel;
    }

    public function removeMilestoneResouceAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $em = $this->entityManager;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            $id = $post['id'];
            $trainingResourceMilestoneEntity = $em->find(TrainingMilestoneResources::class, $id);
            $em->remove($trainingResourceMilestoneEntity);
            $em->flush();
            
            $response->setStatusCode(202);
        }
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
     * @param \Training\Service\ProgrammesService $programmesService            
     */
    public function setProgrammesService($programmesService)
    {
        $this->programmesService = $programmesService;
        return $this;
    }

    /**
     *
     * @param \Bbmin\Controller\unknow $renderer            
     */
    public function setRenderer($renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }

    /**
     *
     * @param field_type $createCourseForm            
     */
    public function setCreateCourseForm($createCourseForm)
    {
        $this->createCourseForm = $createCourseForm;
        return $this;
    }

    /**
     *
     * @param \Training\Form\CourseForm $courseForm            
     */
    public function setCourseForm($courseForm)
    {
        $this->courseForm = $courseForm;
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
}
