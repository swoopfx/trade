<?php
namespace Transaction\Entity;

use Doctrine\ORM\Mapping as ORM;
use Shop\Entity\Cart;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use CsnUser\Entity\User;
use Shop\Entity\OrderStatus;

/**
 * @ORM\Entity
 * @ORM\Table(name="invoice" ,uniqueConstraints={@ORM\UniqueConstraint(name="search_idx", columns={"invoice_uid"})})
 *
 * @author otaba
 *        
 */
class Invoice
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="CsnUser\Entity\User")
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(name="invoice_uid", type="string", nullable=false)
     *
     * @var string
     */
    private $invoiceUid;

    /**
     * @ORM\ManyToOne(targetEntity="Shop\Entity\Cart")
     *
     * @var Cart
     */
    private $cart;

    /**
     * @ORM\Column(name="amount", type="string", nullable=false)
     *
     * @var string
     */
    private $amount;

    /**
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="invoice")
     *
     * @var Collection
     */
    private $transaction;
    
    

    /**
     * @ORM\ManyToOne(targetEntity="InvoiceStatus")
     *
     * @var InvoiceStatus
     */
    private $invoiceStatus;

    
    /**
     * @ORM\Column(name="due_date", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $dueDate;

    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     *
     * @var \DateTime
     */
    private $createdOn;

    /**
     * @ORM\Column(name="updated_on", type="datetime", nullable=false)
     *
     * @var \DateTime
     */
    private $updatedOn;
    
    /**
     * @ORM\ManyToOne(targetEntity="PaymentMethod")
     * @var PaymentMethod
     */
    private $paymentMethod;

    /**
     */
    public function __construct()
    {
        $this->transaction = new ArrayCollection();
    }

    /**
     *
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return the $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     *
     * @return the $invoiceUid
     */
    public function getInvoiceUid()
    {
        return $this->invoiceUid;
    }

    /**
     *
     * @return the $cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     *
     * @return the $amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     *
     * @return the $transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     *
     * @return the $invoiceStatus
     */
    public function getInvoiceStatus()
    {
        return $this->invoiceStatus;
    }

    /**
     *
     * @return the $dueDate
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     *
     * @return the $createdOn
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     *
     * @return the $updatedOn
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     *
     * @param number $id            
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @param \CsnUser\Entity\User $user            
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     *
     * @param string $invoiceUid            
     */
    public function setInvoiceUid($invoiceUid)
    {
        $this->invoiceUid = $invoiceUid;
        return $this;
    }

    /**
     *
     * @param \Shop\Entity\Cart $cart            
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
        return $this;
    }

    /**
     *
     * @param string $amount            
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public function addTransaction(Transaction $transaction)
    {
        if (! $this->transaction->contains($transaction)) {
            $this->transaction[] = $transaction;
            $transaction->setInvoice($this);
        }
        return $this;
    }

    public function removeTransaction(Transaction $transaction)
    {
        if ($this->transaction->contains($transaction)) {
            $this->transaction->removeElement($transaction);
            $transaction->setInvoice(NULL);
        }
        return $this;
    }

    // /**
    // * @param \Doctrine\Common\Collections\Collection $transaction
    // */
    // public function setTransaction($transaction)
    // {
    // $this->transaction = $transaction;
    // return $this;
    // }
    
    /**
     *
     * @param \Transaction\Entity\InvoiceStatus $invoiceStatus            
     */
    public function setInvoiceStatus($invoiceStatus)
    {
        $this->invoiceStatus = $invoiceStatus;
        return $this;
    }

    /**
     *
     * @param DateTime $dueDate            
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    /**
     *
     * @param DateTime $createdOn            
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        $this->updatedOn = $createdOn;
        return $this;
    }

    /**
     *
     * @param DateTime $updatedOn            
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;
        return $this;
    }
}

