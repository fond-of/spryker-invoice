<?php

namespace FondOfSpryker\Zed\Invoice\Persistence;

use Orm\Zed\Invoice\Persistence\FosInvoice;
use Orm\Zed\Invoice\Persistence\FosInvoiceQuery;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \FondOfSpryker\Zed\Invoice\Persistence\InvoicePersistenceFactory getFactory()
 */
class InvoiceQueryContainer extends AbstractQueryContainer implements InvoiceQueryContainerInterface
{
    /**
     * @return \Orm\Zed\Invoice\Persistence\FosInvoiceQuery
     */
    public function queryInvoices(): FosInvoiceQuery
    {
        return $this->getFactory()->createInvoiceQuery();
    }

    /**
     *
     * @param string $orderReference
     *
     * @return \Orm\Zed\Invoice\Persistence\SpyInvoiceQuery
     *
     */
    public function queryInvoiceByOrderReference(string $orderReference)
    {
        return $this->queryInvoices()->findOneByOrderReference($orderReference);
    }

    /**
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Invoice\Persistence\FosInvoice
     */
    public function queryInvoiceByIdSalesOrder(int $idSalesOrder): FosInvoice
    {
        return $this->queryInvoices()->findOneByFkSalesOrder($idSalesOrder);
    }

}
