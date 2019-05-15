<?php

namespace FondOfSpryker\Zed\Invoice\Business\Invoice;

use Generated\Shared\Transfer\InvoiceAddressTransfer;

interface AddressInterface
{
    /**
     * @param \Generated\Shared\Transfer\InvoiceAddressTransfer $addressTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceAddressTransfer
     */
    public function createAddress(InvoiceAddressTransfer $addressTransfer);
}
