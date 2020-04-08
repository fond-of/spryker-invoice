<?php

namespace FondOfSpryker\Zed\Invoice\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\AddressTransfer;
use Orm\Zed\Invoice\Persistence\FosInvoiceAddress;

class InvoiceAddressMapper implements InvoiceAddressMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     * @param \Orm\Zed\Invoice\Persistence\FosInvoiceAddress $fosInvoiceAddress
     *
     * @return \Orm\Zed\Invoice\Persistence\FosInvoiceAddress
     */
    public function mapTransferToEntity(
        AddressTransfer $addressTransfer,
        FosInvoiceAddress $fosInvoiceAddress
    ): FosInvoiceAddress {
        $fosInvoiceAddress->fromArray(
            $addressTransfer->modifiedToArray(false)
        );

        return $fosInvoiceAddress;
    }
}
