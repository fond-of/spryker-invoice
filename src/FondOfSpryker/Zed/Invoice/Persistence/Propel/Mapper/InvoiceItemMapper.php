<?php

namespace FondOfSpryker\Zed\Invoice\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\ItemTransfer;
use Orm\Zed\Invoice\Persistence\FosInvoiceItem;

class InvoiceItemMapper implements InvoiceItemMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \Orm\Zed\Invoice\Persistence\FosInvoiceItem $fosInvoiceItem
     *
     * @return \Orm\Zed\Invoice\Persistence\FosInvoiceItem
     */
    public function mapTransferToEntity(
        ItemTransfer $itemTransfer,
        FosInvoiceItem $fosInvoiceItem
    ): FosInvoiceItem {
        $fosInvoiceItem->fromArray(
            $itemTransfer->modifiedToArray(false)
        );

        return $fosInvoiceItem;
    }

    /**
     * @param \Orm\Zed\Invoice\Persistence\FosInvoiceItem $fosInvoiceItem
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    public function mapEntityToTransfer(
        FosInvoiceItem $fosInvoiceItem,
        ItemTransfer $itemTransfer
    ): ItemTransfer {
        return $itemTransfer->fromArray(
            $fosInvoiceItem->toArray(),
            true
        );
    }
}
