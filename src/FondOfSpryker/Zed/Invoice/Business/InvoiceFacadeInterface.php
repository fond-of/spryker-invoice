<?php

namespace FondOfSpryker\Zed\Invoice\Business;

use Generated\Shared\Transfer\InvoiceListTransfer;
use Generated\Shared\Transfer\InvoiceResponseTransfer;
use Generated\Shared\Transfer\InvoiceTransfer;

interface InvoiceFacadeInterface
{
    /**
     * Specification:
     * - find Invoices ByCustomerReference
     *
     * @param \Generated\Shared\Transfer\InvoiceListTransfer $invoiceListTransfer
     * @param string $customerReference
     *
     * @return mixed
     */
    public function findInvoicesByCustomerReference(InvoiceListTransfer $invoiceListTransfer, string $customerReference);

    /**
     * Specification:
     * - create Invoice
     *
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceResponseTransfer
     */
    public function addInvoice(InvoiceTransfer $invoiceTransfer,  array $creditmemoItemCollection): InvoiceResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer
     */
    public function findInvoiceById(InvoiceTransfer $invoiceTransfer): InvoiceTransfer;

    /**
     * Specification:
     * - Checks if Invoice is Created
     *
     * @api
     *
     * @param int $idSalesOrder
     * @param int $idSalesOrderItem
     *
     * @return bool
     */
    public function isInvoiceAppointed($idSalesOrder, $idSalesOrderItem);

}
