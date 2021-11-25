<?php
namespace Wallet\Service;

use Doctrine\ORM\EntityManager;
use Laminas\Authentication\AuthenticationService;
use General\Service\GeneralService;
use Laminas\Session\Container;
use Wallet\Entity\ReferalUnits;

/**
 *
 * @author otaba
 *        
 */
class ReferalService
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var string
     */
    private $userId;

    /**
     *
     * @var AuthenticationService
     */
    private $auth;

    /**
     *
     * @var GeneralService
     */
    private $generalSerivce;

    /**
     *
     * @var Container
     */
    private $generalSession;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function getReferalUnits()
    {
        if ($this->userId != NULL) {
            $em = $this->entityManager;
            /**
             *
             * @var ReferalUnits $referalUnitsEntity
             */
            $referalUnitsEntity = $em->getRepository("Wallet\Entity\ReferalUnits")->findOneBy(array(
                "user" => $this->userId
            ));
            if ($referalUnitsEntity != NULL) {
                return $referalUnitsEntity->getRunits();
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function getReferalHistory()
    {}

    public static function generateReferalCode()
    {
        $length = 6;
        $string = "";
        $vowels = array(
            "a",
            "e",
            "i",
            "o",
            "u"
        );
        $consonants = array(
            "b",
            "c",
            "d",
            "f",
            "g",
            "h",
            "j",
            "k",
            "l",
            "m",
            "n",
            "p",
            "q",
            "r",
            "s",
            "t",
            "v",
            "w",
            "x",
            "y",
            "z"
        );
        $number = array(
            "1",
            "2",
            "3",
            "4",
            "5",
            "6",
            "7"
        );
        // srand((double)microtime()*100000);
        $max = $length / 2;
        for ($i = 1; $i < $max; $i ++) {
            $string .= $consonants[rand(0, 19)];
            $string .= $vowels[rand(0, 4)];
            $string .= $number[rand(0, 6)];
        }
        
        return $string;
    }

    /**
     * This gets all unprocessed referal sent out 
     * @return \Doctrine\Persistence\object[]|array
     */
    public function getOutstandingReferal()
    {
        $em = $this->entityManager;
        $data = $em->getRepository("Wallet\Entity\Refferal")->findBy(array(
            "user" => $this->userId,
            "isRegistered" => FALSE
        ), array(
            "id"=>"DESC"
        ), 20);
        return $data;
    }

    /**
     *
     * @param \Doctrine\ORM\EntityManager $entityManager            
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     *
     * @param string $userId            
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     *
     * @param \Laminas\Authentication\AuthenticationService $auth            
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
        return $this;
    }

    /**
     *
     * @param \General\Service\GeneralService $generalSerivce            
     */
    public function setGeneralSerivce($generalSerivce)
    {
        $this->generalSerivce = $generalSerivce;
        return $this;
    }

    /**
     *
     * @param \Laminas\Session\Container $generalSession            
     */
    public function setGeneralSession($generalSession)
    {
        $this->generalSession = $generalSession;
        return $this;
    }
}

