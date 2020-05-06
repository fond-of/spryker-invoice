<?php

namespace FondOfSpryker\Zed\Invoice\Persistence;

use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\InvoiceTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Orm\Zed\Invoice\Persistence\FosInvoice;
use Orm\Zed\Invoice\Persistence\FosInvoiceAddress;
use Orm\Zed\Invoice\Persistence\FosInvoiceItem;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \FondOfSpryker\Zed\Invoice\Persistence\InvoicePersistenceFactory getFactory()
 */
class InvoiceEntityManager extends AbstractEntityManager implements InvoiceEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer
     */
    public function createInvoice(
        InvoiceTransfer $invoiceTransfer
    ): InvoiceTransfer {
        $fosInvoice = $this->getFactory()
            ->createInvoiceMapper()
            ->mapTransferToEntity($invoiceTransfer, new FosInvoice());

        $fosInvoice->save();

        return $invoiceTransfer->setIdInvoice(
            $fosInvoice->getIdInvoice()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     *
     * @return \Generated\Shared\Transfer\AddressTransfer
     */
    public function createInvoiceAddress(
        AddressTransfer $addressTransfer
    ): AddressTransfer {
        $fosInvoiceAddress = $this->getFactory()
            ->createInvoiceAddressMapper()
            ->mapTransferToEntity($addressTransfer, new FosInvoiceAddress());

        $fosInvoiceAddress->save();

        return $addressTransfer->setIdInvoiceAddress(
            $fosInvoiceAddress->getIdInvoiceAddress()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    public function createInvoiceItem(
        ItemTransfer $itemTransfer
    ): ItemTransfer {
        $fosInvoiceItem = $this->getFactory()
            ->createInvoiceItemMapper()
            ->mapTransferToEntity($itemTransfer, new FosInvoiceItem());

        $fosInvoiceItem->save();

        return $itemTransfer->setIdInvoiceItem(
            $fosInvoiceItem->getIdInvoiceItem()
        );
    }
}
