<?php

namespace FondOfSpryker\Zed\Invoice\Persistence;

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
    public function createFosInvoiceQuery()
    {
        return FosInvoiceQuery::create();
    }

    /**
     * @return \FondOfSpryker\Zed\Invoice\Persistence\Mapper\InvoiceMapperInterface

    public function createInvoiceMapper(): InvoiceMapperInterface
    {
        return new InvoiceMapper();
    }*/
}
