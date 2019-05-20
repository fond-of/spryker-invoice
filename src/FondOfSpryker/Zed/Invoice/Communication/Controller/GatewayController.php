<?php

namespace FondOfSpryker\Zed\Invoice\Communication\Controller;

use Generated\Shared\Transfer\InvoiceListTransfer;
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
    public function findInvoicesByCustomerReferenceAction(InvoiceListTransfer $invoiceListTransfer)
    {
        return $this->getFacade()->findInvoicesByCustomerReference($invoiceListTransfer, $invoiceListTransfer->getCustomerReference());
    }

    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceResponseTransfer
     */
    public function createAction(InvoiceTransfer $invoiceTransfer)
    {
        $invoiceResponseTransfer = $this->getFacade()->createInvoice($invoiceTransfer);

        $this->triggerEventsOnSuccess($invoiceResponseTransfer);

        return $invoiceResponseTransfer;
    }

    /**
     * @internal param TransactionStatusResponse $response
     *
     * @param \Generated\Shared\Transfer\PayoneTransactionStatusUpdateTransfer $transactionStatusUpdateTransfer
     *
     * @return void
     */
    protected function triggerEventsOnSuccess(InvoiceResponseTransfer $invoiceResponseTransfer)
    {
        if (!$invoiceResponseTransfer->getIsSuccess()) {
            return;
        }

        $orderItems = SpySalesOrderItemQuery::create()
            ->useOrderQuery()
            ->useSpyPaymentPayoneQuery()
            ->filterByTransactionId($transactionStatusUpdateTransfer->getTxid())
            ->endUse()
            ->endUse()
            ->find();

        $this->getFactory()->getOmsFacade()->triggerEvent('InvoiceNotificationReceived', $orderItems, []);

        if ($transactionStatusUpdateTransfer->getTxaction() === PayoneConstants::PAYONE_TXACTION_APPOINTED) {
            $this->getFactory()->getOmsFacade()->triggerEvent('RedirectResponseAppointed', $orderItems, []);
        }
    }
}
