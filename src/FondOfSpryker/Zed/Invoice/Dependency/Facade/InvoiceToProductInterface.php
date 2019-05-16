<?php

namespace FondOfSpryker\Zed\Invoice\Dependency\Facade;

interface InvoiceToProductInterface
{
    /**
     * @param string $sku
     *
     * @return int
     */
    public function findIdProductAbstactByConcreteSku(string $sku): int;

    /**
     * @param string $sku
     *
     * @return int
     */
    public function findProductConcreteIdBySku(string $sku): int;
}
