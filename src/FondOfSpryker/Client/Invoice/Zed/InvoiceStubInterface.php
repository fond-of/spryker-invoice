<?php

namespace FondOfSpryker\Client\Invoice\Zed;

use Generated\Shared\Transfer\InvoiceListTransfer;
use Generated\Shared\Transfer\InvoiceResponseTransfer;
use Generated\Shared\Transfer\InvoiceTransfer;

interface InvoiceStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer
     */
    public function findInvoiceByOrderReference(InvoiceTransfer $invoiceTransfer) : InvoiceResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceResponseTransfer
     */
    public function create(InvoiceTransfer $invoiceTransfer);


}
