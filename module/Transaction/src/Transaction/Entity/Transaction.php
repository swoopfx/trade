<?php
namespace Transaction\Entity;

use Doctrine\ORM\Mapping as ORM;
use Settings\Entity\CheckoutPaymentMethod;

/**
 * @ORM\Entity
 * @ORM\Table(name="transaction")
 * @author otaba
 *        
 */
class Transaction
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\Column(name="transaction_uid", type="string", nullable=true)
     * @var string
     */
    private $transactionUid;
    
    /**
     * @ORM\ManyToOne(targetEntity="TransactionStatus")
     * @var TransactionStatus
     */
    private $transactionStatus;
    
    /**
     * @ORM\ManyToOne(targetEntity="Receipt")
     * @var Receipt
     */
    private $receipt;
    
    /**
     * @ORM\ManyToOne(targetEntity="Invoice", inversedBy="transaction")
     * @var Invoice
     */
    private $invoice;
    
    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     * @var \DateTime
     */
    private $createdOn;
    
    /**
     * @ORM\ManyToOne(targetEntity="Settings\Entity\CheckoutPaymentMethod")
     * @var CheckoutPaymentMethod
     */
    private $transactionType;
    
    
    
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
     * @return the $transactionUid
     */
    public function getTransactionUid()
    {
        return $this->transactionUid;
    }

    /**
     * @return the $transactionStatus
     */
    public function getTransactionStatus()
    {
        return $this->transactionStatus;
    }

    /**
     * @return the $receipt
     */
    public function getReceipt()
    {
        return $this->receipt;
    }

    /**
     * @return the $invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
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
     * @param string $transactionUid
     */
    public function setTransactionUid($transactionUid)
    {
        $this->transactionUid = $transactionUid;
        return $this;
    }

    /**
     * @param \Transaction\Entity\TransactionStatus $transactionStatus
     */
    public function setTransactionStatus($transactionStatus)
    {
        $this->transactionStatus = $transactionStatus;
        return $this;
    }

    /**
     * @param \Transaction\Entity\Receipt $receipt
     */
    public function setReceipt($receipt)
    {
        $this->receipt = $receipt;
        return $this;
    }

    /**
     * @param \Transaction\Entity\Invoice $invoice
     */
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;
        return $this;
    }

    /**
     * @param DateTime $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
//         $this->;
        return $this;
    }
    /**
     * @return the $transactionType
     */
    public function getTransactionType()
    {
        return $this->transactionType;
    }

    /**
     * @param \Settings\Entity\CheckoutPaymentMethod $transactionType
     */
    public function setTransactionType($transactionType)
    {
        $this->transactionType = $transactionType;
        return $this;
    }


}

