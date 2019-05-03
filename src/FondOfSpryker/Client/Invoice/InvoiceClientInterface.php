<?php

namespace FondOfSpryker\Client\Invoice;

use Generated\Shared\Transfer\OrderListTransfer;
use Generated\Shared\Transfer\OrderTransfer;

interface InvoiceClientInterface
{
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
    public function getCustomerInvoices(InvoiceListTransfer $invoiceListTransfer);

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
    public function getPaginatedCustomerInvoices(InvoiceListTransfer $invoiceListTransfer);

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
    public function getOrderDetails(InvoiceTransfer $invoiceTransfer);

}
