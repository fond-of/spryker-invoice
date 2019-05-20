<?php

namespace FondOfSpryker\Zed\Invoice\Persistence;

use Generated\Shared\Transfer\InvoiceListTransfer;

interface InvoiceRepositoryInterface
{
    /**
     * @param string $customerReference
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer|null
     */
    public function findInvoicesByCustomerReference(string $customeReference);

}
