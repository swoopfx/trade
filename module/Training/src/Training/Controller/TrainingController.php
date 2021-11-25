<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Training for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Training\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use WasabiLib\Ajax\Response;
use WasabiLib\Modal\WasabiModal;
use WasabiLib\Modal\WasabiModalView;
use Doctrine\ORM\EntityManager;
use Training\Service\TrainingService;
use Training\Entity\Training;
use WasabiLib\Ajax\InnerHtml;
use Laminas\Mvc\MvcEvent;
use Training\Entity\UserSubmittedTrainingAssignment;

class TrainingController extends AbstractActionController
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    private $renderer;

    /**
     *
     * @var TrainingService
     */
    private $trainingService;

    private $trainingPaginator;
    
    public function onDispatch(MvcEvent $e)
    {
        $response = parent::onDispatch($e);
//         $this->redirectPlugin()->redirectToLogout();
//         $this->redirectPlugin()->adminRedirection();
        return $response;
    }

    public function indexAction()
    {
        $this->redirectPlugin()->redirectToLogout();
        $trainingService = $this->trainingService;
        $progress = $trainingService->getInProgressTraining();
        $recenttrainig = $trainingService->getMostRecentTraining();
        $viewModel = new ViewModel(array(
            "inProgress" => $progress,
            "recentTraining" => $recenttrainig
        ));
        return $viewModel;
    }

    public function allAction()
    {
//         $this->redirectPlugin()->redirectToLogout();
        $em = $this->entityManager;
        $trainings = $this->trainingPaginator;
        $viewModel = new ViewModel(array(
            "trainings" => $trainings
        ));
        return $viewModel;
    }

    public function courseAction()
    {
        $this->redirectPlugin()->redirectToLogout();
        $viewModel = new ViewModel(array());
        return $viewModel;
    }

    public function programmesAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function sponsoredAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function rewardinfomodalAction()
    {
        $response = new Response();
        $wasabi = new WasabiModal("standard");
        $viewModel = new ViewModel();
        $wasabi->setContent($viewModel);
        $viewModel->setTemplate("training_reward_information_modal");
        $modalView = new WasabiModalView("#wasabi", $this->renderer, $wasabi);
        $response->add($modalView);
        return $this->getResponse()->setContent($response);
    }

    /**
     * INofrmation abot a speicific training
     * 
     * @return \Laminas\Http\Response|\Laminas\View\Model\ViewModel
     */
    public function viewAction()
    {
//         $this->redirectPlugin()->redirectToLogout();
        $em = $this->entityManager;
        $id = $this->params()->fromRoute("id");
//         $this->trainingService->get
        $viewModel = new ViewModel();
        if (isset($id) == NULL) {
            return $this->redirect()->toRoute("training/default", array(
                "action" => "all"
            ));
        }
        $trainingEntity = $em->getRepository(Training::class)->findOneBy([
            "trainingUid" => strip_tags($id)
        ]);
        if ($trainingEntity == NULL) {
            return $this->redirect()->toRoute("training/default", array(
                "action" => "all"
            ));
        }
        $viewModel->setVariables(array(
            "training" => $trainingEntity
        ));
        
        return $viewModel;
    }
    
    /**
     * This
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function isMilestoneSubmitted()
    {
       
        $response = $this->getResponse();
        $user = $this->identity();
        $params = $this->params()->fromQuery();
        
        $milestoneId = $params['mid'];
        $trainingId = $params['tid'];
        if($milestoneId != NULL){
            $em = $this->entityManager;
            $repo = $em->getRepository(UserSubmittedTrainingAssignment::class);
            $data = $repo->createQueryBuilder('u')
            ->select([
                'u',
                't'
            ])
            ->leftJoin("u.userTraining", 't')
            ->where("t.training = :tr")
            ->andWhere("u.milestone = :ml")
            ->andWhere("t.user = :us")
            ->setParameters([
                "us" => $user->getId(),
                "ml" => $milestoneId,
                "tr" => $trainingId
            ])
            ->getQuery()
            ->getResult();
            $bool = $data == NULL ? false : true;
            return $bool;
        }else{
            return false;
        }
        
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
     * @param \Doctrine\ORM\EntityManager $entityManager            
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     *
     * @param field_type $trainingService            
     */
    public function setTrainingService($trainingService)
    {
        $this->trainingService = $trainingService;
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
}
