<?php
namespace Application\View\Helper\App;

use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Wallet\Service\ReferalService;

/**
 *
 * @author otaba
 *        
 */
class ApplicationReferalOutstandingHelper extends AbstractHelper implements ServiceLocatorAwareInterface
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

    public function __invoke()
    {
        /**
         *
         * @var ReferalService $referalService
         */
        $referalService = $this->getServiceLocator()
            ->getServiceLocator()
            ->get("Wallet\Service\ReferalService");
        
        $fram = "<div class='card card-people-list mg-t-20'>
					<div class='slim-card-title'>Outstanding Referals</div>
					<div class='media-list'>
            {$this->frame($referalService->getOutstandingReferal())}
            
					</div>
					<!-- media-list -->
				</div>";
        return $fram;
    }

    private function frame($data)
    {
        $fra = "";
        if (count($data) > 0) {
            for ($i = 0; $i < (count($data) < 6 ? count($data) : 6); $i ++) {
                $fra .= "<div class='media'>
							<img src='http://via.placeholder.com/500x500' alt=''>
							<div class='media-body'>
							<a  href=''>{$data[$i]->getReferalEmail()}</a>
								
							</div>
							<!-- media-body -->

							<a href='' class='btn btn-secondary btn-xs' data-href='' data-toggle='tooltip' data-placement='top'
								title='Send Reminder'>Reminder</a>
						</div>
						<!-- media -->";
            }
            return $fra;
        }
    }
}

