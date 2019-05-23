<?php

namespace FondOfSpryker\Zed\Invoice\Business\TransactionStatus;

use FondOfSpryker\Zed\Invoice\Business\Model\Invoice\InvoiceHydratorInterface;
use FondOfSpryker\Zed\Invoice\Persistence\InvoiceQueryContainerInterface;
use FondOfSpryker\Zed\Invoice\Persistence\InvoiceRepositoryInterface;
use Generated\Shared\Transfer\InvoiceTransfer;

class TransactionStatusUpdateManager implements TransactionStatusUpdateManagerInterface
{
    /**
     * @var \FondOfSpryker\Zed\Invoice\Persistence\InvoiceQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @var \FondOfSpryker\Zed\Invoice\Business\Model\Invoice\InvoiceHydratorInterface
     */
    protected $invoiceHydrator;

    /**
     * @var \FondOfSpryker\Zed\Invoice\Persistence\InvoiceRepositoryInterface
     */
    protected $invoiceRepository;

    /**
     * TransactionStatusUpdateManager constructor.
     *
     * @param \FondOfSpryker\Zed\Invoice\Persistence\InvoiceQueryContainerInterface $queryContainer
     */
    public function __construct(
        InvoiceQueryContainerInterface $queryContainer,
        InvoiceRepositoryInterface $invoiceRepository,
        InvoiceHydratorInterface $invoiceHydrator
    ) {

        $this->queryContainer = $queryContainer;
        $this->invoiceRepository = $invoiceRepository;
        $this->invoiceHydrator = $invoiceHydrator;
    }

    /**
     * @param int $idSalesOrder
     * @param int $idSalesOrderItem
     *
     * @return bool
     */
    public function isInvoiceAppointed($idSalesOrder, $idSalesOrderItem): bool
    {
        return $this->IsInvoiced($idSalesOrder, $idSalesOrderItem);
    }

    /**
     * @param int $idSalesOrder
     * @param int $idSalesOrderItem
     *
     * @return bool
     */
    protected function IsInvoiced($idSalesOrder, $idSalesOrderItem): bool
    {
        $invoiceTransfer = $this->findInvoiceByIdSalesOrder($idSalesOrder);

        if ($invoiceTransfer == null) {
           return false;
        }

        return true;
    }

    /**
     * @param int $idSalesOrder
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer|null
     */
    protected function findInvoiceByIdSalesOrder(int $idSalesOrder): ?InvoiceTransfer
    {
        $invoiceEntity = $this->invoiceRepository->findInvoicesByIdSalesOrder($idSalesOrder);

        if ($invoiceEntity == null)
        {
            return null;
        }

        return $this->invoiceHydrator->hydrateInvoiceTransferFromPersistenceByInvoice($invoiceEntity);
    }
}