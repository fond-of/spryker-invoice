<?php

namespace FondOfSpryker\Zed\Invoice\Business;

use Generated\Shared\Transfer\InvoiceListTransfer;
use Generated\Shared\Transfer\InvoiceTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\Invoice\Business\InvoiceBusinessFactory getFactory()
 */
class InvoiceFacade extends AbstractFacade implements InvoiceFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\InvoiceListTransfer $invoiceListTransfer
     * @param string $customerReference
     *
     * @return \Generated\Shared\Transfer\InvoiceResponseTransfer
     */
    public function findInvoicesByCustomerReference(InvoiceListTransfer $invoiceListTransfer, string $customerReference)
    {
        return $this->getFactory()->createInvoiceReader()->findInvoicesByCustomerReference($invoiceListTransfer, $customerReference);
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
