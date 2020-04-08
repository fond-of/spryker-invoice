<?php

namespace FondOfSpryker\Zed\Invoice\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\InvoiceTransfer;
use Orm\Zed\Invoice\Persistence\FosInvoice;

class InvoiceMapper implements InvoiceMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     * @param \Orm\Zed\Invoice\Persistence\FosInvoice $fosInvoice
     *
     * @return \Orm\Zed\Invoice\Persistence\FosInvoice
     */
    public function mapTransferToEntity(
        InvoiceTransfer $invoiceTransfer,
        FosInvoice $fosInvoice
    ): FosInvoice {
        $fosInvoice->fromArray(
            $invoiceTransfer->modifiedToArray(false)
        );

        $addressTransfer = $invoiceTransfer->getAddress();

        if ($addressTransfer !== null && $addressTransfer->getIdInvoiceAddress() !== null) {
            $fosInvoice->setFkInvoiceAddress(
                $addressTransfer->getIdInvoiceAddress()
            );
        }

        return $fosInvoice;
    }

    /**
     * @param \Orm\Zed\Invoice\Persistence\FosInvoice $fosInvoice
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer
     */
    public function mapEntityToTransfer(
        FosInvoice $fosInvoice,
        InvoiceTransfer $invoiceTransfer
    ): InvoiceTransfer {
        return $invoiceTransfer->fromArray($fosInvoice->toArray(), true);
    }
}
