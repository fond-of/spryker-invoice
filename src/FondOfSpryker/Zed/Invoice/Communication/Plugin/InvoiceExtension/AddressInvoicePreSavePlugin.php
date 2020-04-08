<?php

namespace FondOfSpryker\Zed\Invoice\Communication\Plugin\InvoiceExtension;

use FondOfSpryker\Zed\InvoiceExtension\Dependency\Plugin\InvoicePreSavePluginInterface;
use Generated\Shared\Transfer\InvoiceTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\Invoice\Business\InvoiceFacade getFacade()
 */
class AddressInvoicePreSavePlugin extends AbstractPlugin implements InvoicePreSavePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer
     */
    public function preSave(InvoiceTransfer $invoiceTransfer): InvoiceTransfer
    {
        return $this->getFacade()->createInvoiceAddress($invoiceTransfer);
    }
}
