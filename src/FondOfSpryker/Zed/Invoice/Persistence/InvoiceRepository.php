<?php

namespace FondOfSpryker\Zed\Invoice\Persistence;

use Generated\Shared\Transfer\InvoiceListTransfer;
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
}
