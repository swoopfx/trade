<?php
namespace Bbmin\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;

/**
 *
 * @author otaba
 *        
 */
class BBminLayoutTopBarMenu extends AbstractHelper implements ServiceLocatorAwareInterface
{

    private $auth;

    private $entityManager;

    private $serviceLocator;
    
    public function __invoke()
    {
        $viewHelperManager = $this->getServiceLocator()
        ->getServiceLocator()
        ->get("ViewHelperManager");
        
        $url = $viewHelperManager->get("url");
        $logout = $url("logout");
        $frame ="<li class='dropdown navbar-user'><a href='javascript:;'
					class='dropdown-toggle' data-toggle='dropdown'>  <span
						class='d-none d-md-inline'>Administrator</span> <b class='caret'></b>
				</a>
					<div class='dropdown-menu dropdown-menu-right'>
						<a href='javascript:;' class='dropdown-item'>Edit Profile</a> <a
							href='javascript:;' class='dropdown-item'><span
							class='badge badge-danger pull-right'>2</span> Inbox</a> <a
							href='javascript:;' class='dropdown-item'>Calendar</a> <a
							href='javascript:;' class='dropdown-item'>Setting</a>
						<div class='dropdown-divider'></div>
						<a href='{$logout}' class='dropdown-item'>Log Out</a>
					</div></li>";
        return $frame;
    }
    
    public function frame(){
//         $frame = ""
    }
    /**
     * {@inheritDoc}
     * @see \Laminas\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
     */
    public function setServiceLocator(\Laminas\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator  = $serviceLocator;
        return $this;
        
    }

    /**
     * {@inheritDoc}
     * @see \Laminas\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

}

