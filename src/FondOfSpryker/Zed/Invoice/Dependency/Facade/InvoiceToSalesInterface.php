<?php

namespace FondOfSpryker\Zed\Invoice\Dependency\Facade;

use Generated\Shared\Transfer\OrderTransfer;

interface InvoiceToSalesInterface
{
    /**
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function findSalesOrderByOrderReference(string $orderReference): OrderTransfer;
}
