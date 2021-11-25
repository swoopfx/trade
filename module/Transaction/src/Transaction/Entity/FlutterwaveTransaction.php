<?php
namespace Transaction\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="flutterwave_transaction")
 * @author mac
 *        
 */
class FlutterwaveTransaction
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Transaction")
     * @var Transaction
     */
    private $transaction;
    
    /**
     * @ORM\Column(name="flw_ref", type="string", nullable=true)
     * @var string
     */
    private $flwRef;
    
    /**
     * @ORM\Column(name="flw_transaction_id", type="string", nullable=true)
     * @var string
     */
    private $flwTransactionId;
    
    /**
     * @ORM\Column(name="amount_paid", type="string", nullable=true)
     * @var string
     */
    private $amountPaid;
    
    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     * @var \DateTime
     */
    private $createdOn;
    
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
     * @return the $transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @return the $flwRef
     */
    public function getFlwRef()
    {
        return $this->flwRef;
    }

    /**
     * @return the $flwTransactionId
     */
    public function getFlwTransactionId()
    {
        return $this->flwTransactionId;
    }

    /**
     * @return the $amountPaid
     */
    public function getAmountPaid()
    {
        return $this->amountPaid;
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
     * @param \Transaction\Entity\Transaction $transaction
     */
    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;
        return $this;
    }

    /**
     * @param string $flwRef
     */
    public function setFlwRef($flwRef)
    {
        $this->flwRef = $flwRef;
        return $this;
    }

    /**
     * @param string $flwTransactionId
     */
    public function setFlwTransactionId($flwTransactionId)
    {
        $this->flwTransactionId = $flwTransactionId;
        return $this;
    }

    /**
     * @param string $amountPaid
     */
    public function setAmountPaid($amountPaid)
    {
        $this->amountPaid = $amountPaid;
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

