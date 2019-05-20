<?php

namespace FondOfSpryker\Zed\Invoice\Communication\Plugin\Oms\Condition;

use Generated\Shared\Transfer\InvoiceTransfer;

/**
 * @method \SprykerEco\Zed\Payone\Business\PayoneFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Payone\Communication\PayoneCommunicationFactory getFactory()
 */
class CreateIsApprovedConditionPlugin extends AbstractPlugin
{
    const NAME = 'CreateIsApprovedPlugin';

    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return bool
     */
    protected function callFacade(InvoiceTransfer $invoiceTransfer)
    {
        return true;
    }
}
