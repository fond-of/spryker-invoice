<?php

namespace FondOfSpryker\Zed\Invoice\Communication;

use FondOfSpryker\Zed\Invoice\InvoiceDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use SprykerEco\Zed\Payone\Business\Key\UrlHmacGenerator;
use SprykerEco\Zed\Payone\PayoneDependencyProvider;

/**
 * @method \SprykerEco\Zed\Payone\PayoneConfig getConfig()
 * @method \SprykerEco\Zed\Payone\Persistence\PayoneQueryContainerInterface getQueryContainer()
 */
class InvoiceCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \SprykerEco\Zed\Payone\Dependency\Facade\PayoneToOmsInterface
     */
    public function getOmsFacade()
    {
        return $this->getProvidedDependency(InvoiceDependencyProvider::FACADE_OMS);
    }
}
