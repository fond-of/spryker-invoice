<?php

namespace FondOfSpryker\Zed\Invoice\Persistence;

use FondOfSpryker\Zed\Invoice\Persistence\Propel\Mapper\InvoiceAddressMapper;
use FondOfSpryker\Zed\Invoice\Persistence\Propel\Mapper\InvoiceAddressMapperInterface;
use FondOfSpryker\Zed\Invoice\Persistence\Propel\Mapper\InvoiceItemMapper;
use FondOfSpryker\Zed\Invoice\Persistence\Propel\Mapper\InvoiceItemMapperInterface;
use FondOfSpryker\Zed\Invoice\Persistence\Propel\Mapper\InvoiceMapper;
use FondOfSpryker\Zed\Invoice\Persistence\Propel\Mapper\InvoiceMapperInterface;
use Orm\Zed\Invoice\Persistence\FosInvoiceItemQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfSpryker\Zed\Invoice\InvoiceConfig getConfig()
 * @method \FondOfSpryker\Zed\Invoice\Persistence\InvoiceEntityManagerInterface getEntityManager()
 * @method \FondOfSpryker\Zed\Invoice\Persistence\InvoiceRepositoryInterface getRepository()
 */
class InvoicePersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Invoice\Persistence\FosInvoiceItemQuery
     */
    public function createInvoiceItemQuery(): FosInvoiceItemQuery
    {
        return FosInvoiceItemQuery::create();
    }

    /**
     * @return \FondOfSpryker\Zed\Invoice\Persistence\Propel\Mapper\InvoiceMapperInterface
     */
    public function createInvoiceMapper(): InvoiceMapperInterface
    {
        return new InvoiceMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\Invoice\Persistence\Propel\Mapper\InvoiceAddressMapperInterface
     */
    public function createInvoiceAddressMapper(): InvoiceAddressMapperInterface
    {
        return new InvoiceAddressMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\Invoice\Persistence\Propel\Mapper\InvoiceItemMapperInterface
     */
    public function createInvoiceItemMapper(): InvoiceItemMapperInterface
    {
        return new InvoiceItemMapper();
    }
}
