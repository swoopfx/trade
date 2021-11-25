<?php
namespace Support\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;

/**
 *
 * @author otaba
 *        
 */
class SupportRepository extends EntityRepository
{

    /**
     * 
     * {@inheritDoc}
     * @see \Doctrine\ORM\EntityRepository::count()
     */
    public function count($criteria = null)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT s.id FROM Support\Entity\Support s WHERE s.isActive = :active";
        $query = $em->createQuery($dql)
            ->setParameters(array(
            "active" => TRUE
        ))
            ->getResult(AbstractQuery::HYDRATE_ARRAY);
        
        return count($query);
    }

    /**
     * 
     * @param unknown $offset
     * @param unknown $itemsPerPage
     * @return mixed|\Doctrine\DBAL\Driver\Statement|array|NULL
     */
    public function getItems($offset, $itemsPerPage)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT s, u  FROM Support\Entity\Support s JOIN s.user u WHERE s.isActive = :active ORDER BY s.id DESC";
        $query = $em->createQuery($dql)
            ->setParameters(array(
            "active" => TRUE
        ))
            ->setMaxResults($itemsPerPage)
            ->setFirstResult($offset)
            ->getResult();
        return $query;
    }
    
    
    public function findConversation($msgId){
        $dql = "SELECT c, u, a, s FROM Support\Entity\SupportMessages c LEFT JOIN c.messages s LEFT JOIN c.userState u LEFT JOIN c.adminState a WHERE c.messages = :mess ORDER BY c.id ASC";
        $query = $this->getEntityManager()->createQuery($dql)->setParameters([
            "mess"=>$msgId
        ])->getResult(Query::HYDRATE_ARRAY);
        return $query;
        
    }
    
    public function findSurpportEntityArrayFromId($id){
        $dql = "SELECT s FROM Support\Entity\Support s WHERE s.id = :id ";
        $query = $this->getEntityManager()->createQuery($dql)->setParameters([
            "id"=>$id
        ])->getResult(AbstractQuery::HYDRATE_ARRAY);
        return  $query;
        
    }
}

