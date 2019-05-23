<?php

namespace FondOfSpryker\Zed\Invoice\Persistence;

use Generated\Shared\Transfer\InvoiceListTransfer;
use Generated\Shared\Transfer\InvoiceTransfer;
use Orm\Zed\Invoice\Persistence\FosInvoice;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfSpryker\Zed\Invoice\Persistence\InvoicePersistenceFactory getFactory()
 */
class InvoiceRepository extends AbstractRepository implements InvoiceRepositoryInterface
{
    /**
     * @param string $customerReference
     * @return
     * @throws \Exception
     */
    public function findInvoicesByCustomerReference(string $customerReference)
    {
        return $this->getFactory()
            ->createInvoiceQuery()
            ->findByCustomerReference($customerReference);
    }

    /**
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Invoice\Persistence\FosInvoice
     */
    public function findInvoicesByIdSalesOrder(int $idSalesOrder): ?FosInvoice
    {
        return $this->getFactory()
            ->createInvoiceQuery()
            ->findOneByFkSalesOrder($idSalesOrder);
    }
}
