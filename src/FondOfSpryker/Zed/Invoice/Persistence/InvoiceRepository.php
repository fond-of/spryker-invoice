<?php

namespace FondOfSpryker\Zed\Invoice\Persistence;

use Generated\Shared\Transfer\ItemTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfSpryker\Zed\Invoice\Persistence\InvoicePersistenceFactory getFactory()
 */
class InvoiceRepository extends AbstractRepository implements InvoiceRepositoryInterface
{
    /**
     * @param int $idSalesOrderItem
     *
     * @return \Generated\Shared\Transfer\ItemTransfer|null
     */
    public function findInvoiceItemByIdSalesOrderItem(int $idSalesOrderItem): ?ItemTransfer
    {
        $fosInvoiceItemQuery = $this->getFactory()->createInvoiceItemQuery();

        $fosInvoiceItem = $fosInvoiceItemQuery->filterByFkSalesOrderItem($idSalesOrderItem)
            ->findOne();

        if ($fosInvoiceItem === null) {
            return null;
        }

        return $this->getFactory()->createInvoiceItemMapper()->mapEntityToTransfer(
            $fosInvoiceItem,
            new ItemTransfer()
        );
    }
}
