<?php

namespace FondOfSpryker\Zed\Invoice\Dependency\Facade;

use Orm\Zed\Sales\Persistence\SpySalesOrder;

interface InvoiceToSalesInterface
{
    /**
     * @param string $orderReference
     *
     * @return int
     */
    public function findSalesOrderByOrderReference(string $orderReference);
}
