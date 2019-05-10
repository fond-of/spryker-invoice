<?php

namespace FondOfSpryker\Zed\Invoice\Business\Invoice;

use Generated\Shared\Transfer\InvoiceTransfer;

interface InvoiceInterface
{
    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceResponseTransfer
     */
    public function create(InvoiceTransfer $invoiceTransfer);
}
