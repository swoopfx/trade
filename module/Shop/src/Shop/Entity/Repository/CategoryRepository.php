<?php
namespace Shop\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 *
 * @author otaba
 *        
 */
class CategoryRepository extends EntityRepository
{

   
    public function getSexCategorySizes($categoryId, $sexId){
        $dql = "SELECT s FROM Settings\Entity\Size s WHERE s.sex = :sex ORDER BY s.id DESC";
        $query = $this->getEntityManager()->createQuery($dql)->setParameters([
            "sex"=>$sexd
        ]);
        return $query->getResult(Query::HYDRATE_ARRAY);
    }
    
    public function getAllCategoryArray(){
        $dql = "SELECT c FROM Shop\Entity\Category c ORDER BY c.id DESC";
        $query = $this->getEntityManager()->createQuery($dql)->getResult(Query::HYDRATE_ARRAY);
        return $query;
    }
}

