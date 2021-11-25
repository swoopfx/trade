<?php
namespace Shop\Entity\Repository;

use Doctrine\ORM\AbstractQuery;

class OrderRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     *
     * {@inheritdoc}
     *
     * @see \Doctrine\ORM\EntityRepository::count()
     */
    public function count($criteria = null)
    {
        // $query = $this->getEntityManager()->createQueryBuilder();
        // $query->select(array(
        // "o.id"
        // ))
        // ->from("Shop\Entity\Order", "o")
        // ->where("o.isClosed = :closed")
        // ->setParameters(array(
        // "closed" => FALSE
        // ));
        $dql = "SELECT o.id FROM Shop\Entity\CartOrders o WHERE o.isClosed = :closed";
        $query = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameters(array(
            "closed" => FALSE
        ))
            ->getResult(AbstractQuery::HYDRATE_ARRAY);
        return count($query);
    }

    public function getUnsettledOrderItems($offset, $itemsPerPage)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT o, i, c FROM Shop\Entity\CartOrders o JOIN o.invoice i JOIN o.cart c WHERE o.isClosed = :closed ORDER BY o.id DESC ";
        $query = $em->createQuery($dql)
            ->setMaxResults($itemsPerPage)
            ->setFirstResult($offset)
            ->setParameters(array(
            "closed" => FALSE
        ));
        
        return $query->getResult(AbstractQuery::HYDRATE_ARRAY);
    }

    public function customerOrderCount($userId)
    {
        $dql = "SELECT o, c FROM Shop\Entity\CartOrders o LEFT JOIN o.cart c WHERE o.isClosed = :closed AND c.user = :user";
        $query = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameters(array(
            "closed" => FALSE,
            "user" => $userId
        ))
            ->getResult(AbstractQuery::HYDRATE_ARRAY);
        return count($query);
    }

    public function customerOrederItems($userid, $offset, $itemsPerPage)
    {
//         var_dump($userid);
        $em = $this->getEntityManager();
        $dql = "SELECT o, i, c, dt, ci, p, im, pd FROM Shop\Entity\CartOrders o LEFT JOIN o.invoice i LEFT JOIN o.deliveryType dt LEFT JOIN o.cart c LEFT JOIN c.cartItems ci LEFT JOIN ci.product p LEFT JOIN p.image im LEFT JOIN p.productDescription pd WHERE o.isClosed = :closed AND c.user = :user ORDER BY o.id DESC ";
        $query = $em->createQuery($dql)
            ->setMaxResults($itemsPerPage)
            ->setFirstResult($offset)
            ->setParameters(array(
            "closed" => FALSE,
            "user" => $userid
        ));
        
        return $query->getResult(AbstractQuery::HYDRATE_ARRAY);
    }
    
    
    public function countAdmin($criteria = null)
    {
        // $query = $this->getEntityManager()->createQueryBuilder();
        // $query->select(array(
        // "o.id"
        // ))
        // ->from("Shop\Entity\Order", "o")
        // ->where("o.isClosed = :closed")
        // ->setParameters(array(
        // "closed" => FALSE
        // ));
        $dql = "SELECT o.id FROM Shop\Entity\CartOrders o WHERE o.isClosed = :closed";
        $query = $this->getEntityManager()
        ->createQuery($dql)
        ->setParameters(array(
            "closed" => FALSE
        ))
        ->getResult(AbstractQuery::HYDRATE_ARRAY);
        return count($query);
    }
    
    /**
     * This is the collection used by the admin
     * @param unknown $offset
     * @param unknown $itemsPerPage
     * @return mixed|\Doctrine\DBAL\Driver\Statement|array|NULL
     */
    public function getAdminOrderItems($offset, $itemsPerPage)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT o, os, i, c, u, pr, ci, p, im, pd FROM Shop\Entity\CartOrders o LEFT JOIN o.invoice i LEFT JOIN o.orderStatus os LEFT JOIN o.cart c LEFT JOIN c.user u LEFT JOIN u.profile pr LEFT JOIN c.cartItems ci LEFT JOIN ci.product p LEFT JOIN p.image im LEFT JOIN p.productDescription pd WHERE o.isClosed = :closed ORDER BY o.id DESC ";
        $query = $em->createQuery($dql)
        ->setMaxResults($itemsPerPage)
        ->setFirstResult($offset)
        ->setParameters(array(
            "closed" => FALSE
        ));
        
        return $query->getResult(AbstractQuery::HYDRATE_ARRAY);
    }
}