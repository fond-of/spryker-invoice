<?php

namespace FondOfSpryker\Zed\Invoice\Business\Invoice;

use Generated\Shared\Transfer\InvoiceResponseTransfer;
use Generated\Shared\Transfer\InvoiceTransfer;

interface InvoiceInterface
{
    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     * @param array $invoiceItemCollection
     *
     * @return \Generated\Shared\Transfer\InvoiceResponseTransfer
     */
    public function add(InvoiceTransfer $invoiceTransfer, array $invoiceItemCollection): InvoiceResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer
     */
    public function findById(InvoiceTransfer $invoiceTransfer): InvoiceTransfer;
}
