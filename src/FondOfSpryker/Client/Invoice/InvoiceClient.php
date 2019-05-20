<?php

namespace FondOfSpryker\Client\Invoice;

use Generated\Shared\Transfer\InvoiceListTransfer;
use Generated\Shared\Transfer\InvoiceResponseTransfer;
use Generated\Shared\Transfer\InvoiceTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfSpryker\Client\Invoice\InvoiceFactory getFactory()
 */
class InvoiceClient extends AbstractClient implements InvoiceClientInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\InvoiceTransfer InvoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceResponseTransfer
     */
    public function findInvoicesByCustomerReference(InvoiceListTransfer $invoiceListTransfer)
    {
        return $this->getFactory()
            ->createZedInvoiceStub()
            ->findInvoicesByCustomerReference($invoiceListTransfer);
    }


    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\InvoiceTransfer InvoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceResponseTransfer
     */
    public function createInvoice(InvoiceTransfer $invoiceTransfer)
    {
        return $this->getFactory()
            ->createZedInvoiceStub()
            ->create($invoiceTransfer);
    }
}
