<?php

namespace FondOfSpryker\Zed\Invoice\Business\Model\Invoice;

use Generated\Shared\Transfer\InvoiceTransfer;
use Orm\Zed\Invoice\Persistence\FosInvoice;

interface InvoiceHydratorInterface
{
    /**
     * @param \Orm\Zed\Invoice\Persistence\Base\FosInvoice $invoiceEntity
     *
     * @return mixed
     */
    public function hydrateInvoiceTransferFromPersistenceByInvoice(FosInvoice $invoiceEntity): InvoiceTransfer;

}


