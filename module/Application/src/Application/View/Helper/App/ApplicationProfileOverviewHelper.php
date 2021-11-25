<?php
namespace Application\View\Helper\App;

use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Application\Service\ApplicationService;
use General\Service\GeneralService;
use CsnUser\Entity\User;

/**
 *
 * @author otaba
 *        
 */
class ApplicationProfileOverviewHelper extends AbstractHelper implements ServiceLocatorAwareInterface
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
         * @var GeneralService $generalService
         */
        $generalService = $this->getServiceLocator()->getServiceLocator()->get("General\Service\GeneralService");
        /**
         *
         * @var ApplicationService $applicationService
         */
        $applicationService = $this->getServiceLocator()
            ->getServiceLocator()
            ->get("Application\Service\ApplicationService");
        
            $dateFormat = $this->getServiceLocator()->getServicelocator()->get("ViewHelperManager")->get("dateFormat");
        /**
         * 
         * @var User $userEntity
         */
        $userEntity = $generalService->getUserEntity();
        $urlHelper = $this->getServiceLocator()->getServicelocator()->get("ViewHelperManager")->get("url");
            $editUrl = $urlHelper("appmodal/default", array("action"=>"editprofile"));
            $myWalletUrl = $urlHelper("wallet");
            $referalurl = $urlHelper("referal/default", array("action"=>"make"));
            $jsonData = json_encode(array(
                "data"=>$userEntity->getUsername()
            ));
        return "<div class='card card-profile'>
					<div class='card-body'>
						<div class='media'>
							<img src='http://via.placeholder.com/500x500' alt=''>
							<div class='media-body'>
								<h3 class='card-profile-name'>" . $applicationService->getUserFullName() . "</h3>
								<p class='card-profile-position'>
									User Level : <a href=''>".$applicationService->getUserLevel()."</a>
								</p>
								<p>Birth Date : ".$dateFormat($applicationService->getUserDob(), \IntlDateFormatter::LONG, \IntlDateFormatter::NONE)."</p>
<div class='media mg-t-25'>
							<div>
								<i class='icon ion-ios-telephone-outline tx-24 lh-0'></i>
							</div>
							<div class='media-body mg-l-15 mg-t-4'>
								<h6 class='tx-14 tx-gray-700'>Phone Number</h6>
								<span class='d-block'>" . $applicationService->getUserName() . "</span>
							</div>
							<!-- media-body -->
						</div>



<div class='media mg-t-25'>
							<div>
								<i class='fa fa-home tx-24 lh-0'></i>
							</div>
							<div class='media-body mg-l-15 mg-t-4'>
								<h6 class='tx-14 tx-gray-700'>Address</h6>
								<span class='d-block'>" . $applicationService->getUserAddress() . "</span>
							</div>
							<!-- media-body -->
						</div>


<div class='media mg-t-25'>
							<div>
								<i class='fa fa-bank tx-24 lh-0'></i>
							</div>
							<div class='media-body mg-l-15 mg-t-4'>
								<h6 class='tx-14 tx-gray-700'>Bank Verification Number</h6>
								<span class='d-block'>" . ($applicationService->getUserBvn() ?? '' ) . "</span>
							</div>
							<!-- media-body -->
						</div>


<div class='media mg-t-25'>
							<div>
								<i class='fa fa-image tx-24 lh-0'></i>
							</div>
							<div class='media-body mg-l-15 mg-t-4'>
								<h6 class='tx-14 tx-gray-700'>Identification</h6>
								<span class='d-block'><strong>" . $applicationService->getUserIdentityType() ."</strong>: ". $applicationService->getUserIdentity()."</span>
							</div>
							<!-- media-body -->
						</div>


								
							</div>
							<!-- media-body -->
						</div>
						<!-- media -->
					</div>
					<!-- card-body -->
					<div class='card-footer'>
						<a id='sending_data_button' data-href='' class='card-profile-direct ajax_element' json-data='' ></a>
						<div>
							<a href='' id='sending_data_button' class='ajax_element' data-json='".$jsonData."'  data-href='".$editUrl."'>Edit Profile</a> <a href='' data-href='".$referalurl."' class='ajax_element' id='btn2'>Refer A Friend</a>
						</div>
					</div>
					<!-- card-footer -->
				</div>
				<!-- card -->";
    }
}

