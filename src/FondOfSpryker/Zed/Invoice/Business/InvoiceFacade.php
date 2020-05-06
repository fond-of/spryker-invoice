<?php

namespace FondOfSpryker\Zed\Invoice\Business;

use Generated\Shared\Transfer\InvoiceResponseTransfer;
use Generated\Shared\Transfer\InvoiceTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\Invoice\Business\InvoiceBusinessFactory getFactory()
 */
class InvoiceFacade extends AbstractFacade implements InvoiceFacadeInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     * @return \Generated\Shared\Transfer\InvoiceResponseTransfer
     */
    public function createInvoice(InvoiceTransfer $invoiceTransfer): InvoiceResponseTransfer
    {
        return $this->getFactory()->createInvoiceWriter()->create($invoiceTransfer);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer
     */
    public function createInvoiceAddress(InvoiceTransfer $invoiceTransfer): InvoiceTransfer
    {
        return $this->getFactory()->createInvoiceAddressWriter()->create($invoiceTransfer);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer
     */
    public function createInvoiceItems(InvoiceTransfer $invoiceTransfer): InvoiceTransfer
    {
        return $this->getFactory()->createInvoiceItemsWriter()->create($invoiceTransfer);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return string
     */
    public function createInvoiceReference(): string
    {
        return $this->getFactory()->createInvoiceReferenceGenerator()->generate();
    }
}
