<?php

namespace FondOfSpryker\Zed\Invoice\Persistence;

use Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

interface InvoiceQueryContainerInterface extends QueryContainerInterface
{
    /**
     * @api
     *
     * @param string $orderReference
     *
     * @return \Orm\Zed\Invoice\Persistence\SpyInvoiceQuery
     */
    public function queryInvoiceByOrderReference($orderReference);
}
