<?php
namespace Training\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Training\Entity\Programmes;
use Doctrine\ORM\Query;

/**
 *
 * @author otaba
 *        
 */
class ProgrammesRepository extends EntityRepository
{

   
    public function findProgrammesByTrainingid($id)
    {
        $dql = "SELECT p, c FROM Training\Entity\Programmes p LEFT JOIN p.course c WHERE p.training = :training  ORDER BY p.id ASC";
        
        $query = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameters([
            "training" => $id,
               
        ])
            ->getResult(Query::HYDRATE_ARRAY);
        return $query;
    }
}

