<?php
namespace Bbmin\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Bbmin\Entity\AdminSubmittedAssignment;
use Doctrine\ORM\QueryBuilder;
use Bbmin\Service\BbminService;

/**
 *
 * @author mac
 *        
 */
class AdminSubmittedAssignmentRepository extends EntityRepository
{

    // TODO - Insert your code here
    /**
     * This is a frame for the whole admin query functionality
     * 
     * @param QueryBuilder $builder            
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function synq(QueryBuilder $builder)
    {
        return $builder->select([
            's',
            "ut",
            "u",
            "t",
            "st",
            "utss"
        
        ])
            ->from(AdminSubmittedAssignment::class, 's')
            ->leftJoin("s.userTraining", "ut")
            ->leftJoin("ut.user", "u")
            ->leftJoin("ut.training", "t")
            ->leftJoin("s.status", "st")
            ->leftJoin("ut.submitStatus", "utss");
    }

    public function findAllSubmittedAssignment()
    {
        $em = $this->getEntityManager();
        return $this->synq($em->createQueryBuilder())
            ->getQuery();
    }

    public function findInitiatedAssignment()
    
    {
        $em = $this->getEntityManager();
        return $this->synq($em->createQueryBuilder())
            ->where("s.status = :status")
            ->setParameters([
            "status" => BbminService::BBMIN_SUBMMITED_ASSIGMENT_STATUS_INITIATED
        ])
            ->getQuery();
    }

    public function findCompletedAssignment()
    {
        $em = $this->getEntityManager();
        return $this->synq($em->createQueryBuilder())
            ->where("s.status = :status")
            ->setParameters([
            "status" => BbminService::BBMIN_SUBMMITED_ASSIGMENT_STATUS_COMPLETED
        ])
            ->getQuery();
    }

    public function findDisbursedAssignment()
    {
        $em = $this->getEntityManager();
        return $this->synq($em->createQueryBuilder())
            ->where("s.status = :status")
            ->setParameters([
            "status" => BbminService::BBMIN_SUBMMITED_ASSIGMENT_STATUS_DISBURSED
        ])
            ->getQuery();
    }

    public function findProcessingAssignment()
    {
        $em = $this->getEntityManager();
        return $this->synq($em->createQueryBuilder())
            ->where("s.status = :status")
            ->setParameters([
            "status" => BbminService::BBMIN_SUBMMITED_ASSIGMENT_STATUS_PROCESSING
        ])
            ->getQuery();
    }
}

