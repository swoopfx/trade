<?php
namespace Wallet\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Wallet\Service\WalletService;

class WalletRepository extends EntityRepository
{

    public function findLastWithdrawal($userId)
    {
        $dql = "SELECT wt FROM Wallet\Entity\WalletTransaction wt JOIN wt.wallet w WHERE w.user = :user AND wt.transactionType = :type  ORDER BY wt.id DESC";
        $query = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameters(array(
            "user" => $userId,
            "type" => WalletService::WALLET_TRANSACTION_TYPE_WITHDRAW
        ))
            ->getResult();
       
        return $query;
    }

    public function findLast20Transaction($userId)
    {
        $dql = "SELECT wt FROM Wallet\Entity\WalletTransaction wt JOIN wt.wallet w WHERE w.user = :user ORDER BY wt.id DESC";
        $query = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameters(array(
            "user" => $userId
        ))
            ->setMaxResults(50)
            ->getResult();
        return $query;
    }
    
    
    
    public function count($criteria = null){
//         $queryBuilder = $this->getEntityManager()->createQueryBuilder();
//         $queryBuilder->select(array("w.id", "w.walletUid", 'w.balance', "u.username"))->from("Wallet\Entity\Wallet", "w")->orderBy("w.id", "DESC")->

        $em = $this->getEntityManager();
        return count($em->getRepository("Wallet\Entity\Wallet")->findAll());
    }

    public function getItems($offset, $itemCountPerPage){
        $qb = $this->getEntityManager()->createQueryBuilder();
//        $query = $qb->select("w", "u")
//            ->from("Wallet\Entity\Wallet", "w")
//            ->leftJoin("CsnUser\Entity\User", "u", Query\Expr\Join::WITH)
//            ->orderBy("w.id", "DESC")->setMaxResults($itemCountPerPage);

        $dql = "SELECT w, u FROM Wallet\Entity\Wallet w JOIN w.user u ORDER BY w.id DESC";
        return $this->getEntityManager()->createQuery($dql)
            ->setFirstResult($offset)
            ->setMaxResults($itemCountPerPage)
            ->getResult(Query::HYDRATE_ARRAY);
    }
}

