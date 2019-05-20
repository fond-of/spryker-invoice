<?php

namespace FondOfSpryker\Zed\Invoice\Persistence;

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
     * @api
     *
     * @inheritdoc
     */
    public function queryInvoiceByOrderReference($orderReference)
    {
        $query = $this->queryInvoices();
        $query
            ->findOneByOrderReference($orderReference);



        return $query;
    }

}
