<?php
namespace Transaction\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This is only used when the transaction is successfull
 * @ORM\Entity
 * @ORM\Table(name="receipt", uniqueConstraints={@ORM\UniqueConstraint(name="search_idx", columns={"receipt_uid"})})
 * 
 * @author otaba
 *        
 */
class Receipt
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="receipt_uid", type="string", nullable=true)
     * 
     * @var string
     */
    private $receiptUid;

    /**
     * @ORM\ManyToOne(targetEntity="Transaction")
     * 
     * @var Transaction
     */
    private $transaction;

    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     * 
     * @var \DateTime
     */
    private $createdOn;

    // private
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $receiptUid
     */
    public function getReceiptUid()
    {
        return $this->receiptUid;
    }

    /**
     * @return the $transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @return the $createdOn
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $receiptUid
     */
    public function setReceiptUid($receiptUid)
    {
        $this->receiptUid = $receiptUid;
        return $this;
    }

    /**
     * @param \Transaction\Entity\Transaction $transaction
     */
    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;
        return $this;
    }

    /**
     * @param DateTime $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }

}

