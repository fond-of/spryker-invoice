<?php

namespace FondOfSpryker\Zed\Invoice\Business\Model;

use ArrayObject;
use Exception;
use FondOfSpryker\Zed\Invoice\Persistence\InvoiceEntityManagerInterface;
use Generated\Shared\Transfer\InvoiceErrorTransfer;
use Generated\Shared\Transfer\InvoiceResponseTransfer;
use Generated\Shared\Transfer\InvoiceTransfer;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;

class InvoiceWriter implements InvoiceWriterInterface
{
    use TransactionTrait;

    /**
     * @var \FondOfSpryker\Zed\Invoice\Persistence\InvoiceEntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var \FondOfSpryker\Zed\Invoice\Business\Model\InvoicePluginExecutorInterface
     */
    protected $invoicePluginExecutor;

    /**
     * @param \FondOfSpryker\Zed\Invoice\Persistence\InvoiceEntityManagerInterface $entityManager
     * @param \FondOfSpryker\Zed\Invoice\Business\Model\InvoicePluginExecutorInterface $invoicePluginExecutor
     */
    public function __construct(
        InvoiceEntityManagerInterface $entityManager,
        InvoicePluginExecutorInterface $invoicePluginExecutor
    ) {
        $this->entityManager = $entityManager;
        $this->invoicePluginExecutor = $invoicePluginExecutor;
    }

    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceResponseTransfer
     */
    public function create(
        InvoiceTransfer $invoiceTransfer
    ): InvoiceResponseTransfer {
        $invoiceResponseTransfer = (new InvoiceResponseTransfer())
            ->setIsSuccess(false)
            ->setInvoiceTransfer(null);

        try {
            $invoiceTransfer = $this->getTransactionHandler()->handleTransaction(
                function () use ($invoiceTransfer) {
                    return $this->executeCreateTransaction($invoiceTransfer);
                }
            );

            $invoiceResponseTransfer->setIsSuccess(true)
                ->setInvoiceTransfer($invoiceTransfer);
        } catch (Exception $exception) {
            $errorTransferList = new ArrayObject();

            $errorTransferList->append((new InvoiceErrorTransfer())->setMessage($exception->getMessage()));

            $invoiceResponseTransfer->setErrors($errorTransferList);
        }

        return $invoiceResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer
     */
    protected function executeCreateTransaction(
        InvoiceTransfer $invoiceTransfer
    ): InvoiceTransfer {
        $invoiceTransfer = $this->invoicePluginExecutor
            ->executePreSavePlugins($invoiceTransfer);

        $invoiceTransfer = $this->entityManager->createInvoice($invoiceTransfer);

        return $this->invoicePluginExecutor
            ->executePostSavePlugins($invoiceTransfer);
    }
}
