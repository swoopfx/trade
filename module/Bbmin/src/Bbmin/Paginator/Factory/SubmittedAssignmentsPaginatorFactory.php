<?php
namespace Bbmin\Paginator\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Bbmin\Paginator\SubmmitedAssigmentsPaginator;
use Bbmin\Entity\AdminSubmittedAssignment;

/**
 *
 * @author mac
 *        
 */
class SubmittedAssignmentsPaginatorFactory implements FactoryInterface
{

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    /**
     * {@inheritDoc}
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
     */
    public function createService(\Laminas\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
       $adapter = new SubmmitedAssigmentsPaginator;
       $generalService = $serviceLocator->get("General\Service\GeneralService");
       
       $entityManager =  $generalService->getEntityManager();
       $assignmentRepository = $entityManager->getRepository(AdminSubmittedAssignment::class);
       $adapter->setOrderRepository($orderRepository);
        
    }

}

