<?php

namespace FondOfSpryker\Zed\Invoice\Communication\Controller;

use Generated\Shared\Transfer\InvoiceResponseTransfer;
use Generated\Shared\Transfer\InvoiceTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \FondOfSpyker\Zed\Invoice\Business\InvoiceFacadeInterface getFacade()
 * @method \FondOfSpryker\Zed\Invoice\Communication\InvoiceCommunicationFactory getFactory()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceResponseTransfer
     */
    public function findInvoiceByOrderReferenceAction(InvoiceTransfer $invoiceTransfer): InvoiceResponseTransfer
    {
        return $this->getFacade()->findInvoiceByOrderReference($invoiceTransfer->getOrderReference());
    }

}
