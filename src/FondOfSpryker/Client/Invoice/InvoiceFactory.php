<?php

namespace FondOfSpryker\Client\Invoice;

use FondOfSpryker\Client\Invoice\Zed\InvoiceStub;
use Spryker\Client\Kernel\AbstractFactory;


class InvoiceFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Client\Sales\Zed\SalesStubInterface
     */
    public function createZedInvoiceStub()
    {
        return new InvoiceStub(
            $this->getProvidedDependency(InvoiceDependencyProvider::SERVICE_ZED)
        );
    }
}
