<?php

namespace FondOfSpryker\Zed\Invoice\Business\Invoice;


use Generated\Shared\Transfer\InvoiceResponseTransfer;

interface InvoiceReaderInterface
{
    /**
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\InvoiceResponseTransfer
     */
    public function findInvoiceByOrderReference(string $orderReference): InvoiceResponseTransfer;
}
