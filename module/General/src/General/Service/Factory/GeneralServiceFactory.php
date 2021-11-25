<?php
namespace General\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use General\Service\GeneralService;
use Laminas\Session\Container;
use Laminas\Authentication\AuthenticationService;
use CsnUser\Entity\User;

class GeneralServiceFactory implements FactoryInterface
{

    private $em;

    /**
     *
     * @var AuthenticationService
     */
    private $auth;

    private $userId;
    
    private $userEntity;

    public function __construct()
    {

        // TODO - Insert your code here
    }

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $xserv = new GeneralService();
        
        $generalSession = new Container("general_session");
        $shoppingSession = new Container("shopping_session");
        $em = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $mailService = (getenv('APPLICATION_ENV') == "development" ? $serviceLocator->get("acmailer.mailservice.default") : $serviceLocator->get("acmailer.mailservice.live"));
//         $mailService =  $serviceLocator->get("acmailer.mailservice.default");
//         $odm = $serviceLocator->get("doctrine.documentmanager.odm_default");
        $auth = $serviceLocator->get('Laminas\Authentication\AuthenticationService');
        $viewRenderer = $serviceLocator->get("ViewRenderer");
        $this->em = $em;
        $this->auth = $auth;
        $xserv->setAuth($auth)
            ->setEntityManager($em)
            ->setGeneralSession($generalSession)
            ->setShopppingSession($shoppingSession)
            ->setRenderer($viewRenderer)
            ->setMailService($mailService)
//             ->setOdm($odm)
            ->setUserEntity($this->getUserEntity())
            ->setUserId($this->getUserId());
            
        return $xserv;
    }

    private function getUserRole()
    {
        if ($this->auth->hasIdentity()) {
            $data = $this->auth->getIdentity()
                ->getRole()
                ->getId();
            $this->userRole = $data;
            return $data;
        }
    }

    private function getUserId()
    {
        if ($this->auth->hasIdentity()) {
            $userEntity = $this->auth->getIdentity();
            $this->userId = $userEntity->getId();
            return $this->userId;
        }
    }
    
    private function getUserEntity(){
        if ($this->auth->hasIdentity()) {
            $this->userEntity = $this->auth->getIdentity();
            
            return $this->userEntity;
        }
    }
}

