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
     * @param \Generated\Shared\Transfer\InvoiceListTransfer $invoiceListTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceListTransfer
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
     * @param \Generated\Shared\Transfer\InvoiceListTransfer $invoiceListTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceListTransfer
     */
    /*public function getPaginatedCustomerInvoices(InvoiceListTransfer $invoiceListTransfer)
    {
        return $this->getFactory()
            ->createZedSalesStub()
            ->getPaginatedCustomerInvoices($invoiceListTransfer);
    }*/
    
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer
     */
    /*public function getInvoiceDetails(InvoiceTransfer $invoiceTransfer)
    {
        return $this->getFactory()
            ->createZedSalesStub()
            ->getInvoiceDetails($invoiceTransfer);
    }*/
}
