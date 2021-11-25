<?php
namespace Training\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 *
 * @author otaba
 *        
 */
class CourseRepository extends EntityRepository
{

    // // TODO - Insert your code here
    
    // /**
    // */
    // public function __construct(EntityManagerInterface $em, ClassMetadata $class)
    // {
    // parent::__construct($em, $class);
    // // TODO - Insert your code here
    // }
    public function findCourseByUid($uid)
    {
        $dql = "SELECT c from Training\Entity\Course c WHERE c.courseUid = :uid";
        $query = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameters([
            "uid" => $uid
        ])
            ->getResult(Query::HYDRATE_ARRAY);
        return $query;
    }
}

