<?php
namespace Training\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;
use Training\Service\ClassroomService;
use Training\Entity\Training;
use Laminas\Http\Response;
use Training\Entity\UserCourseActivity;
use Training\Entity\Course;
use Training\Entity\UserTraining;
use Training\Entity\TrainingReward;
use Doctrine\ORM\Query;
use Training\Entity\TrainingStatus;
use Training\Service\TrainingService;
use CsnUser\Entity\User;
use Wallet\Entity\Wallet;
use Wallet\Service\WalletService;
use General\Service\GeneralService;
use Wallet\Entity\WalletActivity;
use Wallet\Entity\WalletActivityType;
use Training\Service\YoutubeApiService;
use Bbmin\Entity\AdminSubmittedAssignment;
use Bbmin\Entity\AdminSubmittedAssignmentStatus;
use Bbmin\Service\BbminService;
use Doctrine\ORM\EntityRepository;

/**
 *
 * @author otaba
 *        
 */
class ClassroomController extends AbstractActionController
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
     * @var ClassroomService
     */
    private $classroomService;

    /**
     *
     * @var YoutubeApiService
     */
    private $youtibeApiService;

    /**
     * Main room activity
     *
     * @return \Laminas\Http\Response|\Laminas\View\Model\ViewModel
     */
    public function roomAction()
    {
        $this->redirectPlugin()->redirectToLogout();
        $em = $this->entityManager;
        $viewModel = new ViewModel();
        $trainingUid = $this->params()->fromRoute('trainingUid');
        
        if ($trainingUid != NULL) {
            $classroomSession = $this->classroomService->getClassroomSession();
            /**
             *
             * @var Training $trainingEntity
             */
            $trainingEntity = $em->getRepository(Training::class)->findOneBy([
                "trainingUid" => strip_tags($trainingUid)
            ]);
            
            $user = $this->identity();
            
            $data = $em->getRepository(UserTraining::class)->findOneBy([
                "training" => $trainingEntity->getId(),
                "user" => $user->getId()
            ]);
            
            if ($trainingEntity != NULL) {
                $classroomSession->trainingId = $trainingEntity->getId();
                $viewModel->setVariables([
                    "training" => $trainingEntity,
                    "userTraining" => $data
                ]);
            } else {
                $this->flashmessenger()->addErrorMessage("Absent training Identifier");
                return $this->redirect()->toRoute("training/default", [
                    "action" => "all"
                ]);
            }
        } else {
            $this->flashmessenger()->addErrorMessage("Absent training Identifier");
            return $this->redirect()->toRoute("training/default", [
                "action" => "all"
            ]);
        }
        
        return $viewModel;
    }

    /**
     * Used to activate enrollment of a training program
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function enrollAction()
    {
        $em = $this->entityManager;
        $classroomSession = $this->classroomService->getClassroomSession();
        $jsonModel = new JsonModel();
        $trainingUid = $this->params()->fromRoute("trainingUid");
        $response = $this->getResponse();
        if ($trainingUid != NULL) {
            $trainingEntity = $em->getRepository(Training::class)->findOneBy([
                "trainingUid" => $trainingUid
            ]);
            $classroomSession->trainingId = $trainingId = $trainingEntity->getId();
            try {
                
                $enrollment = $this->classroomService->enrollment($trainingId);
                if ($enrollment) {
                    
                    $response->setStatusCode(Response::STATUS_CODE_201);
                    /**
                     *
                     * @var Training $trainingEntity
                     */
                    // $trainingEntity = $em->find(Training::class, $trainingId);
                    $jsonModel->setVariables([
                        "trainingUid" => $trainingEntity->getTrainingUid()
                        // "url"=>$this->url()->fromRoute("classroom", array("trainingUid"=>$trainingEntity->getTrainingUid()))
                    ]);
                } else {
                    $response->setStatusCode(Response::STATUS_CODE_510);
                }
            } catch (\Exception $e) {
                $jsonModel->setVariables([
                    "message" => $e->getMessage()
                ]);
                $response->setStatusCode(Response::STATUS_CODE_422);
            }
        }
        
        return $jsonModel;
    }

    public function takenCoursesAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $response = $this->getResponse();
        $user = $this->identity();
        $trainingId = $this->params()->fromRoute("trainingUid");
        try {
            $userTrainingEntity = $em->getRepository(UserTraining::class)->findOneBy([
                "training" => $trainingId,
                "user" => $user->getId()
            ]);
            $repo = $em->getRepository(UserCourseActivity::class);
            $takenCourses = $repo->createQueryBuilder("c")
                ->select([
                "c",
                "co"
            ])
                ->where("c.userTraining = :training")
                ->leftJoin("c.course", "co")
                ->setParameters([
                "training" => $userTrainingEntity->getId()
            ])
                ->getQuery()
                ->getResult(Query::HYDRATE_ARRAY);
            
            $response->setStatusCode(200);
            $jsonModel->setVariables([
                "taken" => $takenCourses
            ]);
        } catch (\Exception $e) {
            $jsonModel->setVariables([
                "messages" => "Something went wrong",
                "data" => $e->getMessage()
            ]);
        }
        return $jsonModel;
    }

    public function roomcourseactivityAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $em = $this->entityManager;
        $user = $this->identity();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $this->params()->fromPost();
            $user = $this->identity();
            $courseId = $post["courseId"];
            $trainingId = $post["trainingId"];
            
            $userCourseActivity = $em->getRepository(UserCourseActivity::class)->findOneBy([
                "user" => $user->getId(),
                "course" => $courseId
            ]);
            if ($userCourseActivity == NULL) {
                try {
                    $userTrainingEntity = $em->getRepository(UserTraining::class)->findOneBy([
                        "training" => $trainingId,
                        "user" => $user->getId()
                    ]);
                    $courseActivity = new UserCourseActivity();
                    $courseActivity->setCourse($em->find(Course::class, $courseId))
                        ->setUserTraining($userTrainingEntity)
                        ->setCreatedOn(new \DateTime())
                        ->setUser($user);
                    
                    $em->persist($courseActivity);
                    $em->flush();
                    
                    $response->setStatusCode(201);
                } catch (\Exception $e) {
                    $response->setStatusCode(500);
                    $jsonModel->setVariables([
                        "messages" => "Something went wrong"
                    ]);
                }
            }
        }
        return $jsonModel;
    }

    public function enrollsAction()
    {
        return new ViewModel();
    }

    public function getprogrammesAction()
    {
        $em = $this->entityManager;
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $trainingUid = $this->params()->fromRoute("trainingUid");
        if ($trainingUid != NULL) {
            $programmes = $this->classroomService->getClassroomProgrammes($trainingUid);
            $response->setStatusCode(Response::STATUS_CODE_200);
            $jsonModel->setVariables([
                "programmes" => $programmes
            ]);
        } else {
            $response->setStatusCode(Response::STATUS_CODE_423);
        }
        
        return $jsonModel;
    }

    public function activateCourseCountAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        $userEntity = $this->identity();
        $response = $this->getResponse();
        $trainingId = $this->params()->fromRoute("trainingUid");
        
        $repo = $em->getRepository(UserTraining::class);
        /**
         *
         * @var UserTraining $userTraining
         */
        $userTraining = $repo->createQueryBuilder("t")
            ->select([
            "t",
            "ca"
        ])
            ->leftJoin("t.courseActivity", "ca")
            ->where("t.user = :user")
            ->andWhere("t.training = :train")
            ->setParameters([
            "user" => $userEntity->getId(),
            "train" => $trainingId
        ])
            ->getQuery()
            ->getResult();
        $count = ($userTraining == NULL ? 0 : count($userTraining[0]->getCourseActivity()));
        // var_dump($userTraining[0]->getCourseActivity());
        
        $jsonModel->setVariables([
            "count" => $count
        ]);
        $response->setStatusCode(200);
        return $jsonModel;
    }

    /**
     * Returns a boolean if specific customer has reward for this specific training
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function trainingRewardAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $trainingId = $this->params()->fromRoute("trainingUid");
        $userEntity = $this->identity();
        $em = $this->entityManager;
        $repo = $em->getRepository(TrainingReward::class);
        $reward = $repo->createQueryBuilder("r")
            ->select("r")
            ->where("r.user = :user")
            ->andWhere("r.training = :train")
            ->setParameters([
            "user" => $userEntity->getId(),
            "train" => $trainingId
        ])
            ->getQuery()
            ->getResult();
        $result = ($reward == null ? true : false);
        $response->setStatusCode(200);
        $jsonModel->setVariables([
            "data" => $result
        ]);
        return $jsonModel;
    }

    public function submitassignmentstatusAction()
    {
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        $trainingId = $this->params()->fromRoute("trainingUid");
        
        $userEntity = $this->identity();
        // var_dump($userEntity->getId());
        // var_dump($trainingId);
        $em = $this->entityManager;
        
        $repo = $em->getRepository(UserTraining::class);
        
        $userTrainingEntity = $repo->findOneBy([
            "user" => $userEntity->getId(),
            "training" => $trainingId
        ]);
        
        $srepo = $em->getRepository(AdminSubmittedAssignment::class)->findOneBy([
            "userTraining" => $userTrainingEntity->getId()
        ]);
        
        $result = ($srepo == null ? true : false);
        $response->setStatusCode(200);
        $jsonModel->setVariables([
            "data" => $result
        ]);
        return $jsonModel;
    }

    /**
     * Used to hydrate and activate reward for a successfull training
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function activateTrainingRewardAction()
    {
        $isEligible = false;
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        /**
         *
         * @var User $user
         */
        $user = $this->identity();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $youtubeApiService = $this->youtibeApiService;
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $trainingId = $this->params()->fromRoute("trainingUid");
            $trainingReward = $em->getRepository(TrainingReward::class)->findOneBy([
                "training" => $trainingId,
                'user' => $user->getId()
            ]);
            
            if ($trainingReward !== NULL) {
                $jsonModel->setVariables([
                    "messages" => "You have been rewarded for this training"
                ]);
                $response->setStatusCode(200);
            } else {
                try {
                    /**
                     *
                     * @var Training $trainingEntity
                     */
                    $trainingEntity = $em->find(Training::class, $trainingId);
                    $trainingRewardEntity = new TrainingReward();
                    $trainingRewardEntity->setCreatedOn(new \DateTime())
                        ->setTraining($trainingEntity)
                        ->setUser($user);
                    /**
                     *
                     * @var UserTraining $userTrainingEntity
                     */
                    $userTrainingEntity = $em->getRepository(UserTraining::class)->findOneBy([
                        "user" => $user->getId(),
                        "training" => $trainingEntity->getId()
                    
                    ]);
                    
                    $userTrainingEntity->setEndDate(new \DateTime())
                        ->setStatus($em->find(TrainingStatus::class, TrainingService::TRAINING_STATUS_COMPLETED))
                        ->setUpdatedOn(new \DateTime());
                    
                    // get eligibility here
                    $youtube = $youtubeApiService->process($userTrainingEntity);
                    $walletEntity = $user->getWallet();
                    if ($youtube["isEligible"]) {
                        if ($walletEntity == null) {
                            $walletEntity = new Wallet();
                            $walletEntity->setCreatedOn(new \DateTime())
                                ->setUser($user)
                                ->setWalletUid(WalletService::generateWalletUid());
                        }
                        $newBalance = ($walletEntity->getBalance() == null ? 0 : $walletEntity->getBalance()) + $trainingEntity->getTrainingPoints();
                        $walletEntity->setBalance($newBalance)->setUpdatedOn(new \DateTime());
                        
                        $walletActiviyEntity = new WalletActivity();
                        
                        $walletActiviyEntity->setCreatedOn(new \DateTime())
                            ->setDesc("Reward allocated")
                            ->setWallet($walletEntity)
                            ->setType($em->find(WalletActivityType::class, WalletService::WALLET_ACTIVITY_TYPE_CREDIT));
                        
                        $em->persist($trainingRewardEntity);
                        $em->persist($userTrainingEntity);
                        $em->persist($walletEntity);
                        $em->persist($walletActiviyEntity);
                        
                        $em->flush();
                        
                        $generalService = $this->generalService;
                        
                        $pointer["to"] = $user->getEmail();
                        $pointer["fromName"] = GeneralService::APP_COMPANY_NAME;
                        $pointer['subject'] = "Tfits Entrepreneur Journey";
                        
                        $template['template'] = "training-begin-journey-mail";
                        $template["var"] = [
                            "logo" => $this->url()->fromRoute('home', array(), array(
                                'force_canonical' => true
                            )) . "img/logo.png"
                        
                        ];
                        $generalService->sendMails($pointer, $template);
                        
                        $response->setStatusCode(201);
                        $this->flashmessenger()->addSuccessMessage("You have been awarded {$trainingEntity->getTrainingPoints()} reward points in your wallet");
                    } else {
                        $trainingRewardEntity = new TrainingReward();
                        $trainingRewardEntity->setCreatedOn(new \DateTime())
                            ->setTraining($trainingEntity)
                            ->setUser($user);
                        
                        $em->persist($trainingRewardEntity);
                        $em->flush();
                        $response->setStatusCode(401);
                        
                        $jsonModel->setVariables([
                            "messages" => "Ohhhh No !!!, Our system detects you have not conformed to the activity requirements of this course, you are not eligible"
                        
                        ]);
                    }
                } catch (\Exception $e) {
                    $jsonModel->setVariables([
                        "messages" => "We could not process your reward at this time",
                        "data" => $e->getTrace()
                    ]);
                    $response->setStatusCode(500);
                }
            }
        }
        
        return $jsonModel;
    }

    public function submitmilestoneAction()
    {
        $jsonModel = new JsonModel();
        $em = $this->entityManager;
        /**
         *
         * @var User $user
         */
        $user = $this->identity();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $youtubeApiService = $this->youtibeApiService;
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $trainingId = $this->params()->fromRoute("trainingUid");
            $trainingReward = $em->getRepository(TrainingReward::class)->findOneBy([
                "training" => $trainingId,
                'user' => $user->getId()
            ]);
            
            if ($trainingReward !== NULL) {
                $jsonModel->setVariables([
                    "messages" => "You have been rewarded for this training"
                ]);
                $response->setStatusCode(200);
            } else {
                
                /**
                 *
                 * @var Training $trainingEntity
                 */
                $trainingEntity = $em->find(Training::class, $trainingId);
                
                /**
                 *
                 * @var UserTraining $userTrainingEntity
                 */
                $userTrainingEntity = $em->getRepository(UserTraining::class)->findOneBy([
                    "user" => $user->getId(),
                    "training" => $trainingEntity->getId()
                
                ]);
                
                $userTrainingEntity->setEndDate(new \DateTime())
                    ->setStatus($em->find(TrainingStatus::class, TrainingService::TRAINING_STATUS_COMPLETED))
                    ->setUpdatedOn(new \DateTime());
                
                // get eligibility here
                $youtube = $youtubeApiService->process($userTrainingEntity);
                // var_dump($youtube);
                
                $walletEntity = $user->getWallet();
                if ($youtube["isEligible"]) {
                    // user is ellligible for the reward points
                    
                    /*
                     * find if useuser has prevously submitted
                     * if so show information that assignment has been submitted
                     * else hydrate a submitted entity
                     *
                     *
                     */
                    
                    $adminSubmittedAssigmentEntity = $em->getRepository(AdminSubmittedAssignment::class)->findOneBy([
                        "userTraining" => $userTrainingEntity->getId()
                    ]);
                    if ($adminSubmittedAssigmentEntity == NULL) {
                        $adminSubmittedAssigmentEntity = new AdminSubmittedAssignment();
                        $adminSubmittedAssigmentEntity->setCreatedOn(new \DateTime())
                            ->setIsDisbursed(FALSE)
                            ->setStatus($em->find(AdminSubmittedAssignmentStatus::class, BbminService::BBMIN_SUBMMITED_ASSIGMENT_STATUS_INITIATED))
                            ->setUserTraining($userTrainingEntity);
                        
                        $em->persist($adminSubmittedAssigmentEntity);
                        $em->persist($userTrainingEntity);
                        $em->persist($userTrainingEntity);
                        $em->flush();
                        
                        // send emails notification to customer
                        // tell user that assignment would be evaluated and scored
                        
                        $generalService = $this->generalService;
                        
                        $pointer["to"] = $user->getEmail();
                        $pointer["fromName"] = GeneralService::APP_COMPANY_NAME;
                        $pointer['subject'] = GeneralService::APP_NAME . ":: Submitted Assignments";
                        
                        $template['template'] = "training-begin-journey-mail";
                        $template["var"] = [
                            "logo" => $this->url()->fromRoute('home', array(), array(
                                'force_canonical' => true
                            )) . "img/logo.png"
                        
                        ];
                        $generalService->sendMails($pointer, $template);
                        
                        $response->setStatusCode(201);
                        $jsonModel->setVariables([                            // "data" => ""
                        ]);
                        
                        $this->flashMessenger()->addSuccessMessage("Successfully submited your assignment, It would be reviewed by an administrator");
                    } else {
                        $jsonModel->setVariables([
                            "messages" => "You have previously submitted your assignment"
                        ]);
                        $response->setStatusCode(200);
                    }
                } else {
                    $trainingRewardEntity = new TrainingReward();
                    $trainingRewardEntity->setCreatedOn(new \DateTime())
                        ->setTraining($trainingEntity)
                        ->setUser($user);
                    
                    $em->persist($trainingRewardEntity);
                    $em->flush();
                    $response->setStatusCode(400);
                    
                    $jsonModel->setVariables([
                        "messages" => $youtube["messages"] ?? "Ohhhh No !!!, Our system detects you have not conformed to the activity requirements of this course, you are not eligible"
                    
                    ]);
                }
            }
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
     * @param \Training\Service\ClassroomService $classroomService            
     */
    public function setClassroomService($classroomService)
    {
        $this->classroomService = $classroomService;
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
     * @param \Training\Service\YoutubeApiService $youtibeApiService            
     */
    public function setYoutibeApiService($youtibeApiService)
    {
        $this->youtibeApiService = $youtibeApiService;
        return $this;
    }
}

