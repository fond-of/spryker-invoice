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
     * - Returns the invoices for the given customer and filters.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\InvoiceListTransfer $invoiceListTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceListTransfer
     */
   // public function getPaginatedCustomerInvoices(InvoiceListTransfer $invoiceListTransfer);

    /**
     * Specification:
     * - Returns details for the given invoice id.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer
     */
    //public function getOrderDetails(InvoiceTransfer $invoiceTransfer);

}
