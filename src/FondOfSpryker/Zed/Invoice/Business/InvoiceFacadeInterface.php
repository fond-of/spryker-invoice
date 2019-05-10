<?php

namespace FondOfSpryker\Zed\Invoice\Business;

use Generated\Shared\Transfer\InvoiceResponseTransfer;
use Generated\Shared\Transfer\InvoiceTransfer;

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

    /**
     * Specification:
     * - create Invoice
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceResponseTransfer
     */
    public function createInvoice(InvoiceTransfer $invoiceTransfer);

}
