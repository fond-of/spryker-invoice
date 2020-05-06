<?php

namespace FondOfSpryker\Zed\Invoice\Communication\Plugin\InvoiceExtension;

use FondOfSpryker\Zed\InvoiceExtension\Dependency\Plugin\InvoicePostSavePluginInterface;
use Generated\Shared\Transfer\InvoiceTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\Invoice\Business\InvoiceFacade getFacade()
 */
class ItemsInvoicePostSavePlugin extends AbstractPlugin implements InvoicePostSavePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer
     */
    public function postSave(InvoiceTransfer $invoiceTransfer): InvoiceTransfer
    {
        return $this->getFacade()->createInvoiceItems($invoiceTransfer);
    }
}
