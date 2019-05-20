<?php

namespace FondOfSpryker\Zed\Invoice\Persistence;

use Orm\Zed\Invoice\Persistence\Base\FosInvoiceItemQuery;
use Orm\Zed\Invoice\Persistence\FosInvoiceAddressQuery;
use Orm\Zed\Invoice\Persistence\FosInvoiceQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfSpryker\Zed\Invoice\InvoiceConfig getConfig()
 * @method \FondOfSpryker\Zed\Invoice\Persistence\InvoiceQueryContainerInterface getQueryContainer()
 * @method \FondOfSpryker\Zed\Invoice\Persistence\InvoiceEntityManagerInterface getEntityManager()
 * @method \FondOfSpryker\Zed\Invoice\Persistence\InvoiceRepositoryInterface getRepository()
 */
class InvoicePersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Invoice\Persistence\FosInvoiceQuery
     */
    public function createInvoiceQuery()
    {
        return FosInvoiceQuery::create();
    }

    /**
     * @return \Orm\Zed\Invoice\Persistence\FosInvoiceAddressQuery
     */
    public function createInvoiceAddressQuery()
    {
        return FosInvoiceAddressQuery::create();
    }

    /**
     * @return \Orm\Zed\Invoice\Persistence\FosInvoiceItemQuery
     */
    public function createInvoiceItemQuery()
    {
        return FosInvoiceItemQuery::create();
    }

}
