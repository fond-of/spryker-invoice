<?php

namespace FondOfSpryker\Zed\Invoice\Business;

use FondOfSpryker\Zed\Invoice\Business\Invoice\InvoiceReader;
use FondOfSpryker\Zed\Invoice\Business\Invoice\InvoiceReaderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\Invoice\InvoiceConfig getConfig()
 * @method \FondOfSpryker\Zed\Invoice\Persistence\InvoiceEntityManagerInterface getEntityManager()
 * @method \FondOfSpryker\Zed\Invoice\Persistence\InvoiceRepositoryInterface getRepository()
 */
class InvoiceBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\Invoice\Business\Invoice\InvoiceReaderInterface
     */
    public function createInvoiceReader(): InvoiceReaderInterface
    {
        return new InvoiceReader(
            $this->getEntityManager(),
            $this->getRepository()
        );
    }
}
