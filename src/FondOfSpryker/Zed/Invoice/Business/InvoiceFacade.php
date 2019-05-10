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
     * @param string $invoiceReference
     *
     * @return \Generated\Shared\Transfer\InvoiceResponseTransfer
     */
    public function findInvoiceByOrderReference(string $invoiceReference): InvoiceResponseTransfer
    {
        return $this->getFactory()->createInvoiceReader()->findInvoiceByOrderReference($invoiceReference);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceResponseTransfer
     */
    public function createInvoice(InvoiceTransfer $invoiceTransfer)
    {
        return $this->getFactory()
            ->createInvoice()
            ->create($invoiceTransfer);
    }
}
