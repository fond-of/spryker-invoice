<?php

namespace FondOfSpryker\Zed\Invoice\Business\Model;

use FondOfSpryker\Zed\Invoice\Persistence\InvoiceEntityManagerInterface;
use Generated\Shared\Transfer\InvoiceTransfer;

class InvoiceItemsWriter implements InvoiceItemsWriterInterface
{
    /**
     * @var \FondOfSpryker\Zed\Invoice\Persistence\InvoiceEntityManagerInterface
     */
    protected $entityManager;

    /**
     * InvoiceAddressWriter constructor.
     *
     * @param \FondOfSpryker\Zed\Invoice\Persistence\InvoiceEntityManagerInterface $entityManager
     */
    public function __construct(InvoiceEntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer
     */
    public function create(
        InvoiceTransfer $invoiceTransfer
    ): InvoiceTransfer {
        $invoiceTransfer->requireIdInvoice();
        $invoiceTransfer->requireItems();

        foreach ($invoiceTransfer->getItems() as $invoiceItemTransfer) {
            $this->entityManager->createInvoiceItem(
                $invoiceItemTransfer->setFkInvoice(
                    $invoiceTransfer->getIdInvoice()
                )
            );
        }

        return $invoiceTransfer;
    }
}
