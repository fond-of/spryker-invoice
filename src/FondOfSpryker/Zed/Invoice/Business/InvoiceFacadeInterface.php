<?php

namespace FondOfSpryker\Zed\Invoice\Business;

use Generated\Shared\Transfer\InvoiceResponseTransfer;

interface InvoiceFacadeInterface
{
    /**
     * Specification:
     *  - Finds invoice by order reference.
     *  - Returns invoice response transfer.
     *
     * @api
     *
     * @param string $invoiceReference
     *
     * @return \Generated\Shared\Transfer\InvoiceResponseTransfer
     */
    public function findInvoiceByOrderReference(string $orderReference): InvoiceResponseTransfer;
}
