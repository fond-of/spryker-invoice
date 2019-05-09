<?php

namespace FondOfSpryker\Zed\Invoice\Persistence;

use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \FondOfSpryker\Zed\Invoice\Persistence\InvoicePersistenceFactory getFactory()
 */
class InvoiceQueryContainer extends AbstractQueryContainer implements InvoiceQueryContainerInterface
{
    /**
     * @api
     *
     * @inheritdoc
     */
    public function queryInvoiceByOrderReference($orderReference)
    {
        $query = $this->queryInvoices();
        $query->filterByOrderReference($orderReference);

        return $query;
    }

}
