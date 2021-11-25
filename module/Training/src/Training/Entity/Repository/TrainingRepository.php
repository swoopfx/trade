<?php
namespace Training\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Training\Entity\Training;
use Doctrine\ORM\Query;
use Laminas\Db\Sql\Where;

/**
 *
 * @author otaba
 *        
 */
class TrainingRepository extends EntityRepository
{
    
    public function countAdmin($criteria = NULL){
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select(array(
            "t.id"
        ))->from(Training::class, "t")->select("count(t.id)");
        
        $result = $query->getQuery()->getSingleScalarResult();
         return $result;
    }
    
    
    
    public function getAdminItems($offset, $itemCountPerPage){
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select(array(
            "t",
            "tm"
        ))
        ->from(Training::class, "t")
        ->join("t.image", "tm")
        ->setFirstResult($offset)
       
        ->setMaxResults($itemCountPerPage)
        ->orderBy("t.id", "DESC");
        
        $result = $query->getQuery()->getResult(Query::HYDRATE_ARRAY);
        return $result;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Doctrine\ORM\EntityRepository::count()
     */
    public function count($criteria = NULL)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select(array(
            "t.id"
        ))->from(Training::class, "t")->where("t.isPublished = :pub")->setParameters([
            "pub"=>TRUE
        ]);
        
        $result = $query->getQuery()->getResult();
        return count($result);
    }
    
    
    /**
     *
     * {@inheritdoc}
     *
     * @see \Doctrine\ORM\EntityRepository::count()
     */
    public function countTraining($criteria = NULL)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select(array(
            "t.id"
        ))->from(Training::class, "t")->where("t.isPublished = :pub")->setParameters([
            "pub"=>TRUE
        ]);
        
        $result = $query->getQuery()->getResult();
        return count($result);
    }

    /**
     *
     * @param int $offset            
     * @param int $itemCountPerPage            
     * @return mixed|\Doctrine\DBAL\Driver\Statement|array|NULL
     */
    public function getItems($offset, $itemCountPerPage)
    {
        
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select(array(
            "t",
            "tm"
        ))
            ->from(Training::class, "t")
            ->join("t.image", "tm")
            ->setFirstResult($offset)
            ->where("t.isPublished = :pub")->setParameters([
                "pub"=>TRUE
            ])
            ->setMaxResults($itemCountPerPage)
            ->orderBy("t.id", "DESC");
        
        $result = $query->getQuery()->getResult(Query::HYDRATE_ARRAY);
        return $result;
    }

    public function findTrainingByUid($uid)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select("t")
            ->from(Training::class, "t")
            ->where("t.trainingUid = :id")
            ->setParameters([
            "id"=>$uid
        ]);
        $result = $query->getQuery()->getResult(Query::HYDRATE_ARRAY);
        return $result;
    }
}

