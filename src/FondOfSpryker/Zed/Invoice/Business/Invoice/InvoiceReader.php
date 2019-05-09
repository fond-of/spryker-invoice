<?php

namespace FondOfSpryker\Zed\Invoice\Business\Invoice;

use FondOfSpryker\Zed\Invoice\Persistence\InvoiceEntityManagerInterface;
use FondOfSpryker\Zed\Invoice\Persistence\InvoiceRepositoryInterface;
use Generated\Shared\Transfer\InvoiceResponseTransfer;

class InvoiceReader implements InvoiceReaderInterface
{
    /**
     * @var \FondOfSpryker\Zed\Invoice\Persistence\InvoiceEntityManagerInterface
     */
    protected $invoiceEntityManager;

    /**
     * @var \FondOfSpryker\Zed\Invoice\Persistence\InvoiceRepositoryInterface
     */
    protected $invoiceRepository;

    /**
     * @param \FondOfSpryker\Zed\Invoice\Persistence\InvoiceEntityManagerInterface $invoiceEntityManager
     * @param \FondOfSpryker\Zed\Invoice\Persistence\InvoiceRepositoryInterface $invoiceRepository
     */
    public function __construct(
        InvoiceEntityManagerInterface $invoiceEntityManager,
        InvoiceRepositoryInterface $invoiceRepository

    ) {
        $this->invoiceEntityManager = $invoiceEntityManager;
        $this->invoiceRepository = $invoiceRepository;
    }
    
    /**
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\InvoiceResponseTransfer
     */
    public function findInvoiceByOrderReference(string $orderReference): InvoiceResponseTransfer
    {
        $invoiceTransfer = $this->invoiceRepository->findInvoiceByOrderReference($orderReference);

        $invoiceResponseTransfer = (new InvoiceResponseTransfer())
            ->setHasInvoice(false)
            ->setIsSuccess(false);

        if ($invoiceTransfer) {
            $invoiceResponseTransfer->setInvoiceTransfer($invoiceTransfer)
                ->setHasInvoice(true)
                ->setIsSuccess(true);
        }

        return $invoiceResponseTransfer;
    }
}
