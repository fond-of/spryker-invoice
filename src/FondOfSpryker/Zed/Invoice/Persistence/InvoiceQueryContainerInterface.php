<?php

namespace FondOfSpryker\Zed\Invoice\Persistence;

use Orm\Zed\Invoice\Persistence\FosInvoice;
use Orm\Zed\Invoice\Persistence\FosInvoiceQuery;
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
    public function queryInvoiceByOrderReference(string $orderReference);

    /**
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Invoice\Persistence\FosInvoice
     */
    public function queryInvoiceByIdSalesOrder(int $idSalesOrder): FosInvoice;

    /**
     * @param int $idInvoice
     *
     * @return \Orm\Zed\Invoice\Persistence\FosInvoiceQuery
     */
    public function queryInvoiceById(int $idInvoice): FosInvoiceQuery;
}
