<?php

namespace FondOfSpryker\Zed\Invoice\Business;

use Generated\Shared\Transfer\InvoiceListTransfer;
use Generated\Shared\Transfer\InvoiceResponseTransfer;
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
    public function addInvoice(InvoiceTransfer $invoiceTransfer,  array $creditmemoItemCollection): InvoiceResponseTransfer
    {
        return $this->getFactory()
            ->createInvoice()
            ->add($invoiceTransfer, $creditmemoItemCollection);
    }

    /**
     * @param \Generated\Shared\Transfer\CreditmemoTransfer $creditmemoTransfer
     *
     * @return \Generated\Shared\Transfer\CreditmemoTransfer
     */
    public function findInvoiceById(InvoiceTransfer $invoiceTransfer): InvoiceTransfer
    {
        return $this->getFactory()
            ->createInvoice()
            ->findById($invoiceTransfer);
    }


    /**
     * Specification:
     * - Checks if Invoice is Appointed
     *
     * @api
     *
     * @param int $idSalesOrder
     * @param int $idSalesOrderItem
     *
     * @return bool
     */
    public function isInvoiceAppointed($idSalesOrder, $idSalesOrderItem)
    {
        return $this->getFactory()
            ->createTransactionStatusManager()
            ->isInvoiceAppointed($idSalesOrder, $idSalesOrderItem);
    }

    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return bool
     */
    public function isCreateApproved(InvoiceTransfer $invoiceTransfer): bool
    {
        return true;

    }
}
