<?php

namespace FondOfSpryker\Zed\Invoice\Persistence;

use Generated\Shared\Transfer\InvoiceTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfSpryker\Zed\Invoice\Persistence\InvoicePersistenceFactory getFactory()
 */
class InvoiceRepository extends AbstractRepository implements InvoiceRepositoryInterface
{
    /**
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer|null
     */
    public function findInvoiceByOrderReference(string $orderReference): ?InvoiceTransfer
    {
        $invoiceEntity = $this->getFactory()->createFosInvoiceQuery()->findOneByOrderReference($orderReference);

        print_r($invoiceEntity);

        if ($invoiceEntity === null) {
            return null;
        }

        return $this->getFactory()
            ->createInvoiceMapper()
            ->mapInvoiceEntityToInvoice($invoiceEntity->toArray());
    }
}
