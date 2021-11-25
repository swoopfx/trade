<?php
namespace General\View\Helper;

/**
 * 
 */
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorInterface;
use General\Service\GeneralService;

class FirstnameViewHelper extends AbstractHelper implements ServiceLocatorAwareInterface
{

    private $serviceLocator;
    
    public function __construct()
    {

        // TODO - Insert your code here
    }

    public function getServiceLocator()
    {

        return $this->serviceLocator;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {

        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    public function __invoke(){
        /**
         * 
         * @var GeneralService $generalService
         */
        $generalService = $this->getServiceLocator()->getServiceLocator()->get("General\Service\GeneralService");
//         $em = $this->
    }
}

