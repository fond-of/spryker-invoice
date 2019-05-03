<?php

namespace FondOfSpryker\Client\Invoice\Zed;

use Generated\Shared\Transfer\InvoiceListTransfer;
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
     * @param \Generated\Shared\Transfer\InvoiceListTransfer $invoiceListTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceListTransfer
     */
    public function getCustomerInvoices(InvoiceListTransfer $invoiceListTransfer)
    {
        /** @var \Generated\Shared\Transfer\InvoiceListTransfer $invoiceListTransfer */
        $invoiceListTransfer = $this->zedStub->call('/invoices/gateway/get-invoices', $invoiceListTransfer);

        return $invoiceListTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\InvoiceListTransfer $invoiceListTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceListTransfer
     */
    public function getPaginatedCustomerInvoices(InvoiceListTransfer $invoiceListTransfer)
    {
        /** @var \Generated\Shared\Transfer\InvoiceListTransfer $invoiceListTransfer */
        $invoiceListTransfer = $this->zedStub->call('/invoices/gateway/get-paginated-invoices', $invoiceListTransfer);

        return $invoiceListTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer
     */
    public function getInvoiceDetails(InvoiceTransfer $invoiceTransfer)
    {
        /** @var \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer */
        $invoiceTransfer = $this->zedStub->call('/invoices/gateway/get-invoice-details', $invoiceTransfer);

        return $invoiceTransfer;
    }

}
