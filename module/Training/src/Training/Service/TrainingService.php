<?php
namespace Training\Service;

use Doctrine\ORM\EntityManager;
use General\Service\GeneralService;
use Training\Entity\Training;
use Training\Entity\Programmes;
use Training\Entity\Course;
use CsnUser\Entity\User;
use Training\Entity\UserTraining;
use Laminas\Session\Container;

/**
 *
 * @author otaba
 *        
 */
class TrainingService
{

    const TRAINING_STATUS_IN_PROGRESS = 100;

    const TRAINING_STATUS_COMPLETED = 200;

    const TRAINING_STATUS_CANCELLED = 300;
    
    
    
    const USER_TRAINING_SUBMIT_STATUS_SUBMITED = 10;
    
    const USER_TRAINING_SUBMIT_STATUS_EVALUATING = 50;
    
    const USER_TRAINING_SUBMIT_STATUS_EVALUATED = 100;

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
     * @var Container
     */
    private $trainingManagementSession;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public static function generateTrainingUid()
    {
        return uniqid(time());
    }
    
    public function aggregatereward(){
        $em = $this->entityManager;
        /**
         * 
         * @var Training $trainingEntity
         */
        $trainingEntity = $em->getRepository(Training::class)->findBy(["isPublished"=>TRUE]);
        $totalPoints = 0;
//         foreach ($trainingEntity as $points){
//             $point = 0;
//             $point = intval($points->getTrainingPoints()[0]);
//             $totalPoints = $point;
//         }

        for($i = 0; count($trainingEntity) > $i; $i++){
            $point = 0;
            $point += $trainingEntity[$i]->getTrainingPoints();
            $totalPoints = $point;
        }
       
        return count($trainingEntity);
    }

    public function countTotalTraining()
    {
        try {
            
            $em = $this->entityManager;
            // var_dump($em);
            $data = $em->getRepository(Training::class)->findBy(["isPublished"=>TRUE]);
            // $data = $em->find(Training::class, 1);
            // var_dump($data);
            if ($data == NULL) {
                return 0;
            } else {
                return count($data);
            }
        } catch (\Exception $e) {
            // return var_dump($e->getMessage());
        }
    }

    /**
     * This function returns an array filled with details of a raining entity
     * 
     * @param string $uid            
     * @return array
     */
    public function getTrainingByUid(string $uid)
    {
        $em = $this->entityManager;
        /**
         *
         * @var array $trainingArray
         */
        $trainingArray = $em->getRepository(Training::class)->findTrainingByUid($uid);
        return $trainingArray;
    }

    public function countTotalProgrammes()
    {
        $em = $this->entityManager;
        $data = $em->getRepository(Programmes::class)->findAll();
        if ($data == NULL) {
            return 0;
        } else {
            return count($data);
        }
    }

    public function countTotalCourse()
    {
        $em = $this->entityManager;
        $data = $em->getRepository(Course::class)->findAll();
        if ($data == NULL) {
            return 0;
        } else {
            return count($data);
        }
    }

    public function getInProgressTraining()
    {
        $auth = $this->generalService->getAuth();
        $em = $this->entityManager;
        
        if (isset($auth)) {
            /**
             *
             * @var User $userEntity
             */
            $userEntity = $auth->getIdentity();
            $userTraining = $em->getRepository(UserTraining::class)->findBy(array(
                "user" => $userEntity->getId(),
                "status" => self::TRAINING_STATUS_IN_PROGRESS
            
            ));
            return $userTraining;
        }
    }

    public function countTotalTrainingInProgress()
    {
        $userTraining = $this->getInProgressTraining();
        if ($userTraining == NULL) {
            return 0;
        } else {
            return count($userTraining);
        }
    }

    public function getMostRecentTraining()
    {
        $em = $this->entityManager;
        $recentTraining = $em->getRepository(Training::class)->findBy([
            "isPublished"=>TRUE
        ], [
            "id" => "DESC"
        ], 10);
        return $recentTraining;
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
     * @return the $generalService
     */
    public function getGeneralService()
    {
        return $this->generalService;
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
     * @return the $trainingManagementSession
     */
    public function getTrainingManagementSession()
    {
        return $this->trainingManagementSession;
    }

    /**
     *
     * @param \Laminas\Session\Container $trainingManagementSession            
     */
    public function setTrainingManagementSession($trainingManagementSession)
    {
        $this->trainingManagementSession = $trainingManagementSession;
        return $this;
    }
}

