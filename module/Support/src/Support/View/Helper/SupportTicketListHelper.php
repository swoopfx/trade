<?php
namespace Support\View\Helper;

use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Support\Service\SupportService;

/**
 *
 * @author otaba
 *        
 */
class SupportTicketListHelper extends AbstractHelper implements ServiceLocatorAwareInterface
{

    private $servicelocator;

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
        return $this->servicelocator;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
     *
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->servicelocator = $serviceLocator;
        return $this;
    }

    public function __invoke()
    {
        /**
         *
         * @var SupportService $supportService
         */
        $supportService = $this->getServiceLocator()
            ->getServiceLocator()
            ->get("Support\Service\SupportService");
        $supportTicketList = $supportService->getUserRecentSupportTicketObject();
        
        $viewHelpwerManager = $this->getServiceLocator()
            ->getServiceLocator()
            ->get("ViewHelperManager");
       
        $supportIndicator = $viewHelpwerManager->get("supportStatusIndicator");
        $dateformat = $viewHelpwerManager->get("dateformat");
        $html = "";
        if (count($supportTicketList) > 0) {
            
            foreach ($supportTicketList as $ticket) {
                $isUnread = ($ticket->getIsActive() == TRUE ? "unread" : "");
                $title = strtoupper($ticket->getSupportTitle());
                $uid = strtoupper($ticket->getSupportUid());
                $html .= "<a href='' class='media {$isUnread}'>
					<div class='media-left'>
					{$supportIndicator($ticket->getIsActive())}
					</div>
					<!-- media-left -->
					<div class='media-body'>
						<div>
						<h6><strong>{$title}</strong></h6>
						<p>{$uid}</p>
						</div>
						<div>
							<span>{$dateformat($ticket->getUpdatedOn(), \IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE, "en_us")}</span>
						</div>
					</div>
					<!-- media-body -->
				</a>";
            }
            return $html;
        }
    }
}

