<?php

namespace FondOfSpryker\Client\Invoice\Zed;

use Generated\Shared\Transfer\InvoiceListTransfer;
use Generated\Shared\Transfer\InvoiceTransfer;

interface InvoiceStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\InvoiceListTransfer $invoiceListTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceListTransfer
     */
    public function getCustomerInvoices(InvoiceListTransfer $invoiceListTransfer);

    /**
     * @param \Generated\Shared\Transfer\InvoiceListTransfer $invoiceListTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceListTransfer
     */
    public function getPaginatedCustomerInvoices(InvoiceListTransfer $invoiceListTransfer);

    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer
     */
    public function getInvoiceDetails(InvoiceTransfer $invoiceTransfer);

}
