<?php

namespace FondOfSpryker\Zed\Invoice\Persistence;

use Generated\Shared\Transfer\InvoiceTransfer;

interface InvoiceRepositoryInterface
{
    /**
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer|null
     */
    public function findInvoiceByOrderReference(string $orderReference): ?InvoiceTransfer;

}
