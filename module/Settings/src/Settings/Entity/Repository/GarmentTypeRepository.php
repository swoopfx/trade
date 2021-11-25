<?php
namespace Settings\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 *
 * @author otaba
 *        
 */
class GarmentTypeRepository extends EntityRepository
{

    
    
    public function garmentTypeArray($catId){
        $dql = "SELECT g FROM Settings\Entity\GarmentType g WHERE g.category = :cat  ORDER BY g.id DESC";
        $query = $this->getEntityManager()->createQuery($dql)->setParameters(array(
            "cat"=>$catId
        ))->getResult(Query::HYDRATE_ARRAY);
        return $query;
    }
}

