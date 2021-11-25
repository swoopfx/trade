<?php
namespace Application\View\Helper\Dashboard;

use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Application\Service\ApplicationService;
use General\Service\GeneralService;

/**
 *
 * @author otaba
 *        
 */
class DashboardUserWelcomeHelper extends AbstractHelper implements ServiceLocatorAwareInterface
{
    
    private $serviceLocator;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
     *
     */
    public function getServiceLocator()
    {
        
        return $this->serviceLocator;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
     *
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    public function __invoke(){
        // get the service from the application service
        //return The service 
        // if the user has not pofiled is information ,
        // provide link to setup profile information 
       
        /**
         * 
         * @var GeneralService $generalService
         */
        $generalService = $this->getServiceLocator()->getServiceLocator()->get("General\Service\GeneralService");
        
        /**
         * 
         * @var ApplicationService $appService
         */
        $appService= $this->getServiceLocator()->getServiceLocator()->get("Application\Service\ApplicationService");
        $auth = $generalService->getAuth();
        $userId = $generalService->getUserId();
        if($auth->hasIdentity()){
            if($userId != NULL){
            return $appService->nameOfUser();
            }else{
                return NULL;
            }
        }else{
            return NULL;
        }
        
    }
}

