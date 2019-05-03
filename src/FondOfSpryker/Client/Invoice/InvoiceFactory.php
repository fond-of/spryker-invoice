<?php

namespace FondOfSpryker\Client\Invoice;

use FondOfSpryker\Client\Sales\InvoiceDependencyProvider;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\Sales\Zed\SalesStub;

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
