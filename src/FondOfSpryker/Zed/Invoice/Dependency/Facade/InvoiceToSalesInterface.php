<?php

namespace FondOfSpryker\Zed\Invoice\Dependency\Facade;

interface InvoiceToSalesInterface
{
    /**
     * @param string $orderReference
     *
     * @return int
     */
    public function getIdSalesOrderByOrderReference(string $orderReference): int;
}
