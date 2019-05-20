<?php

namespace FondOfSpryker\Zed\Invoice\Business\Invoice;


use Generated\Shared\Transfer\InvoiceListTransfer;

interface InvoiceReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\InvoiceListTransfer $invoiceListTransfer
     * @param string $customerReference
     *
     * @return mixed
     */
    public function findInvoicesByCustomerReference(InvoiceListTransfer $invoiceListTransfer, string $customerReference): InvoiceListTransfer;
}
