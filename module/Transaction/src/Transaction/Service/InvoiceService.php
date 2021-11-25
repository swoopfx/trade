<?php
namespace Transaction\Service;

use Doctrine\ORM\EntityManager;
use Transaction\Entity\Invoice;
use Transaction\Entity\InvoiceStatus;
use Shop\Service\OrderService;
use CsnUser\Entity\User;
use General\Service\GeneralService;
use General\Service\CentralUnitOfWorkInterface;

/**
 *
 * @author ezekiel
 *        
 */
class InvoiceService implements CentralUnitOfWorkInterface
{

    const INVOICE_STATUS_INITIATED = 10;

    const INVOICE_STATUS_PAID = 100;

    const INVOICE_STATUS_CANCELED = 1000;
    
    const INVOICE_STATUS_PART_PAYMENT = 20;

    // TODO - Insert your code here
    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var GeneralService
     */
    private $generalService;

    private $amountPayable;

    private $cart;

    private $dueDate;

    private $unitOfWork;

    private $invoiceEntity;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public static function invoiceUid()
    {
        return uniqid("invoice");
    }

    public function onCheckoutInvoice()
    {
        $em = $this->entityManager;
        $invoiceEntity = new Invoice();
        $invoiceEntity->setAmount($this->amountPayable)
            ->setCart($this->cart)
            ->setCreatedOn(new \DateTime())
            ->setDueDate($this->dueDate)
            ->setInvoiceStatus($em->find(InvoiceStatus::class, self::INVOICE_STATUS_INITIATED))
            ->setInvoiceUid(self::invoiceUid())
            ->setUser($em->find(User::class, $this->generalService->getUserId()));
        
        $em->persist($invoiceEntity);
        $this->setInvoiceEntity($invoiceEntity);
        $this->unitOfWork = $em;
        return $this;
    }

    /**
     *
     * @return the $entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
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
     * @param \General\Service\GeneralService $generalService            
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return $this;
    }

    /**
     *
     * @param field_type $amountPayable            
     */
    public function setAmountPayable($amountPayable)
    {
        $this->amountPayable = $amountPayable;
        return $this;
    }

    /**
     *
     * @param field_type $cart            
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
        return $this;
    }

    /**
     *
     * @param field_type $dueDate            
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    /**
     *
     * @return the $unitOfWork
     */
    public function getUnitOfWork()
    {
        return $this->unitOfWork;
    }

    /**
     *
     * @param field_type $unitOfWork            
     */
    public function setUnitOfWork($unitOfWork)
    {
        $this->unitOfWork = $unitOfWork;
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \General\Service\CentralUnitOfWorkInterface::unitOfWork()
     */
    public function unitOfWork()
    {
        return $this->unitOfWork;
    }

    /**
     *
     * @return the $invoiceEntity
     */
    public function getInvoiceEntity()
    {
        return $this->invoiceEntity;
    }

    /**
     *
     * @param field_type $invoiceEntity            
     */
    public function setInvoiceEntity($invoiceEntity)
    {
        $this->invoiceEntity = $invoiceEntity;
        return $this;
    }
}

