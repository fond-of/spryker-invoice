<?php

namespace FondOfSpryker\Zed\Invoice\Persistence;

use Generated\Shared\Transfer\InvoiceTransfer;
use Orm\Zed\Invoice\Persistence\FosInvoice;

interface InvoiceRepositoryInterface
{
    /**
     * @param string $customerReference
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer|null
     */
    public function findInvoicesByCustomerReference(string $customeReference);

    /**
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Invoice\Persistence\FosInvoice
     */
    public function findInvoicesByIdSalesOrder(int $idSalesOrder): ?FosInvoice;
}
