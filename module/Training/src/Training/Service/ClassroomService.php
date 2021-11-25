<?php
namespace Training\Service;

use Doctrine\ORM\EntityManager;
use Laminas\Session\Container;
use Training\Entity\UserTraining;
use Laminas\Authentication\AuthenticationService;
use Training\Entity\Training;
use ZfcBase\EventManager\EventProvider;
use Training\Entity\TrainingStatus;
use Training\Entity\Programmes;

/**
 *
 * @author otaba
 *        
 */
class ClassroomService extends  EventProvider
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var AuthenticationService
     */
    private $auth;

    /**
     *
     * @var Container
     */
    private $classroomSession;

    public function enrollment($trainingId)
    {
        $em = $this->entityManager;
        /**
         * 
         * @var UserTraining $userTrainingEntity
         */
        $userTrainingEntity = $em->getRepository(UserTraining::class)->findOneBy([
            "training" => $trainingId,
            "user" => $this->auth->getIdentity()
                ->getId()
        ]);
        if ($userTrainingEntity == NULL) {
            $userEntity = new UserTraining();
            $userEntity->setCreatedOn(new \DateTime())
                ->setTraining($em->find(Training::class, $trainingId))
                ->setStartDate(new \DateTime())
                ->setStatus($em->find(TrainingStatus::class, TrainingService::TRAINING_STATUS_IN_PROGRESS))
                ->setUser($this->auth->getIdentity());
            $em->persist($userEntity);
            $em->flush();
            
//             $this->getEventManager()->trigger($event)
            return TRUE;// meanining enrolment was true 
        } else {
            return FALSE; // meanining emrolment was false user has already enrolled for training
        }
    }
    
    
    public function getClassroomProgrammes(?string $trainingUid){
        $em = $this->entityManager;
        if($trainingUid == NULL){
            // get Uid in session
        }
        
        if($trainingUid == NULL){
            throw new \Exception("Absent Training Id");
        }else{
            $trainingEntity = $em->getRepository(Training::class)->findOneBy([
                "trainingUid"=>$trainingUid
            ]);
            $programmes = $em->getRepository(Programmes::class)->findProgrammesByTrainingid($trainingEntity->getId());
            return $programmes;
            // TODO get All programmes and courses related to it in array
        }
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
     * @param \Laminas\Session\Container $classroomSession            
     */
    public function setClassroomSession($classroomSession)
    {
        $this->classroomSession = $classroomSession;
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
     * @return the $classroomSession
     */
    public function getClassroomSession()
    {
        return $this->classroomSession;
    }

}

