<?php

namespace FondOfSpryker\Client\Invoice;

use Generated\Shared\Transfer\InvoiceResponseTransfer;
use Generated\Shared\Transfer\InvoiceTransfer;

interface InvoiceClientInterface
{
    /**
     * Specification:
     * - Returns the invoices for the given order reference.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer
     */
    public function findInvoiceByOrderReference(InvoiceTransfer $invoiceTransfer): InvoiceResponseTransfer;


    /**
     * Specification:
     * - create an Invoice
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function createInvoice(InvoiceTransfer $invoiceTransfer);

}
