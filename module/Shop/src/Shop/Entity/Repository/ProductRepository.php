<?php
namespace Shop\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 *
 * @author otaba
 *        
 */
class ProductRepository extends EntityRepository
{

    // TODO - Insert your code here
    public function findProductBestSeller()
    {
        // $dql = "SELECT p FROM Shop\Entity\Product p "
        $qb = $this->createQueryBuilder("p")
            ->select("p, MAX(p.productCount) AS max_count")
            ->from("Shop\Entity\ProductSalesCount", "p")
            ->setMaxResults(10)
            ->orderBy("max_count", "DESC");
        return $qb->getQuery()->getResult();
    }

    /**
     * counts how nmany products are in the database
     *
     * {@inheritdoc}
     *
     * @see \Doctrine\ORM\EntityRepository::count()
     */
    public function count($criteria = NULL)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select(array(
            'p.id'
        ))->from('Shop\Entity\Product', 'p');
        
        $result = $query->getQuery()->getResult();
        
        return count($result);
    }

    /**
     *
     * @param int $offset
     *            Offset
     * @param int $itemCountPerPage
     *            Max results
     *            
     * @return array
     */
    /**
     * Returns a list of products
     *
     * @param int $offset            
     * @param int $itemCountPerPage            
     * @return mixed|\Doctrine\DBAL\Driver\Statement|array|NULL
     */
    public function getItems($offset, $itemCountPerPage)
    {
        // array('p.id', 'p.productUid', "pd.productName", 'pd.description', "p.isPublished")
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select(array(
            "p",
            "pd"
        ))
            ->from('Shop\Entity\Product', 'p')
            ->leftJoin("p.productDescription", "pd")
            ->setFirstResult($offset)
            ->orderBy("p.id", "DESC")
            ->setMaxResults($itemCountPerPage);
        
        $result = $query->getQuery()->getResult(Query::HYDRATE_ARRAY);
        
        return $result;
    }

    public function publishedCount(): int
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select(array(
            'p.id'
        ))
            ->from('Shop\Entity\Product', 'p')
            ->where("p.isPublished = :pub")
            ->setParameters([
            "pub" => True
        ]);
        
        $result = $query->getQuery()->getResult(Query::HYDRATE_ARRAY);
        
        return count($result);
    }
    
    public function publishedCountObject(): int
    {
        $dql = "SELECT p FROM Shop\Entity\Product p  WHERE  p.isPublished = :pub ORDER BY p.id DESC";
        $query = $this->getEntityManager()
        ->createQuery($dql)
        ->setParameters([
            "pub" => TRUE,
            
        ]);
        $result = count($query->getResult());
        
        return $result;
        
       
    }
    /**
     *
     * @param int $offset
     * @param int $itemCountPerPage
     * @return array
     */
    public function getPublishedProductObject(int $offset, int $itemCountPerPage)
    {
        $dql = "SELECT p, pd FROM Shop\Entity\Product p LEFT JOIN p.productDescription pd WHERE p.isPublished = :pub ORDER BY p.id DESC";
        $query = $this->getEntityManager()
        ->createQuery($dql)
        ->setParameters([
            "pub" => TRUE,
           
        ]);
        $result = $query->getResult();
        //         var_dump(count($result));
        return $result;
        
      
    }

    /**
     *
     * @param int $offset            
     * @param int $itemCountPerPage            
     * @return array
     */
    public function getPublishedItems(int $offset, int $itemCountPerPage): array
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select(array(
            "p",
            "pd"
        ))
            ->from('Shop\Entity\Product', 'p')
            ->leftJoin("p.productDescription", "pd")
            ->setFirstResult($offset)
            ->orderBy("p.id", "DESC")
            ->setMaxResults($itemCountPerPage);
        
        $result = $query->getQuery()->getResult(Query::HYDRATE_ARRAY);
        
        return $result;
    }

    public function productItemByCategoryCount($catId): int
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select([
            "p.id"
        ])
            ->from("Shop\Entity\Product", "p")
            ->where("p.category = :catid")
            ->andWhere("p.isPublished = :isa")
            ->setParameters([
            "catid" => $catId,
            "isa" => TRUE
        ]);
        
        $result = count($query->getQuery()->getResult());
        return $result;
    }

    public function getItemProductByCategory($catId, $offset, $itemCountPerPage)
    {
        $dql = "SELECT p, pd FROM Shop\Entity\Product p LEFT JOIN p.productDescription pd WHERE p.category = :cat AND p.isPublished = :pub ORDER BY p.id DESC";
        $query = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameters([
            "pub" => TRUE,
            "cat" => $catId
        ]);
        $result = $query->getResult();
//         var_dump(count($result));
        return $result;
    }

    public function findMostRecentProductsArray()
    {
        $dql = "SELECT p, m, d FROM \Shop\Entity\Product p LEFT JOIN p.image m  LEFT JOIN p.productDescription d WHERE p.isPublished = :pub  ORDER BY p.updatedOn DESC";
        $query = $this->getEntityManager()
            ->createQuery($dql)
            ->setMaxResults(10)
            ->setParameters(array(
            "pub" => TRUE
        ));
        return $query->getResult(Query::HYDRATE_ARRAY);
    }

    public function findProductsImageArray($id)
    {
        $dql = "SELECT p, i FROM \Shop\Entity\Product p LEFT JOIN p.image i where p.productUid = :id";
        $query = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameters(array(
            "id" => $id
        ));
        return $query->getResult(Query::HYDRATE_ARRAY);
    }
}