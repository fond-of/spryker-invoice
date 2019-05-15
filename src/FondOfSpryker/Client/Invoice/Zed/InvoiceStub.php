<?php

namespace FondOfSpryker\Client\Invoice\Zed;

use Generated\Shared\Transfer\InvoiceResponseTransfer;
use Generated\Shared\Transfer\InvoiceTransfer;
use Spryker\Client\ZedRequest\ZedRequestClient;

class InvoiceStub implements InvoiceStubInterface
{
    /**
     * @var \Spryker\Client\ZedRequest\ZedRequestClient
     */
    protected $zedStub;

    /**
     * @param \Spryker\Client\ZedRequest\ZedRequestClient $zedStub
     */
    public function __construct(ZedRequestClient $zedStub)
    {
        $this->zedStub = $zedStub;
    }

    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer
     */
    public function findInvoiceByOrderReference(InvoiceTransfer $invoiceTransfer): InvoiceResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\InvoiceListTransfer $invoiceListTransfer */
        $invoiceTransfer = $this->zedStub->call('/invoice/gateway/find-invoice-by-order-reference', $invoiceTransfer);

        return $invoiceTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceResponseTransfer
     */
    public function create(InvoiceTransfer $invoiceTransfer)
    {
        /** @var \Generated\Shared\Transfer\InvoiceResponseTransfer $invoiceResponseTransfer */
        $invoiceResponseTransfer = $this->zedStub->call('/invoice/gateway/create', $invoiceTransfer);

        return $invoiceResponseTransfer;
    }


}
