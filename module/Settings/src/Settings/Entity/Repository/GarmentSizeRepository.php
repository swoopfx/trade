<?php
namespace Settings\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 *
 * @author otaba
 *        
 */
class GarmentSizeRepository extends EntityRepository
{

   public function getGarmentSizeArray($sexid, $maturityId){
       $dql = "SELECT s FROM Settings\Entity\Size s WHERE s.sex = :sex AND s.maturityCategory = :mat ORDER BY s.id DESC";
       $query = $this->getEntityManager()->createQuery($dql)->setParameters(array(
           "sex"=>$sexid,
           "mat"=>$maturityId
       ))->getResult(Query::HYDRATE_ARRAY);
       return $query;
   }
}

