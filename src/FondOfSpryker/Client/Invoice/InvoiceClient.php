<?php

namespace FondOfSpryker\Client\Invoice;

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
    public function findInvoiceByOrderReference(InvoiceTransfer $invoiceTransfer): InvoiceResponseTransfer
    {
        return $this->getFactory()
            ->createZedInvoiceStub()
            ->findInvoiceByOrderReference($invoiceTransfer);
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
