<?php

namespace FondOfSpryker\Zed\Invoice\Business;

use FondOfSpryker\Zed\Invoice\Business\Model\InvoiceAddressWriter;
use FondOfSpryker\Zed\Invoice\Business\Model\InvoiceAddressWriterInterface;
use FondOfSpryker\Zed\Invoice\Business\Model\InvoiceItemsWriter;
use FondOfSpryker\Zed\Invoice\Business\Model\InvoiceItemsWriterInterface;
use FondOfSpryker\Zed\Invoice\Business\Model\InvoicePluginExecutor;
use FondOfSpryker\Zed\Invoice\Business\Model\InvoicePluginExecutorInterface;
use FondOfSpryker\Zed\Invoice\Business\Model\InvoiceReferenceGenerator;
use FondOfSpryker\Zed\Invoice\Business\Model\InvoiceReferenceGeneratorInterface;
use FondOfSpryker\Zed\Invoice\Business\Model\InvoiceWriter;
use FondOfSpryker\Zed\Invoice\Business\Model\InvoiceWriterInterface;
use FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToSequenceNumberFacadeInterface;
use FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToStoreFacadeInterface;
use FondOfSpryker\Zed\Invoice\InvoiceDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\Invoice\InvoiceConfig getConfig()
 * @method \FondOfSpryker\Zed\Invoice\Persistence\InvoiceEntityManagerInterface getEntityManager()
 * @method \FondOfSpryker\Zed\Invoice\Persistence\InvoiceRepositoryInterface getRepository()
 */
class InvoiceBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\Invoice\Business\Model\InvoiceWriterInterface
     */
    public function createInvoiceWriter(): InvoiceWriterInterface
    {
        return new InvoiceWriter(
            $this->getEntityManager(),
            $this->createInvoicePluginExecutor()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\Invoice\Business\Model\InvoicePluginExecutorInterface
     */
    protected function createInvoicePluginExecutor(): InvoicePluginExecutorInterface
    {
        return new InvoicePluginExecutor(
            $this->getInvoicePreSavePlugins(),
            $this->getInvoicePostSavePlugins()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\Invoice\Business\Model\InvoiceAddressWriterInterface
     */
    public function createInvoiceAddressWriter(): InvoiceAddressWriterInterface
    {
        return new InvoiceAddressWriter($this->getEntityManager());
    }

    /**
     * @return \FondOfSpryker\Zed\Invoice\Business\Model\InvoiceItemsWriterInterface
     */
    public function createInvoiceItemsWriter(): InvoiceItemsWriterInterface
    {
        return new InvoiceItemsWriter($this->getEntityManager());
    }

    /**
     * @return \FondOfSpryker\Zed\Invoice\Business\Model\InvoiceReferenceGeneratorInterface
     */
    public function createInvoiceReferenceGenerator(): InvoiceReferenceGeneratorInterface
    {
        return new InvoiceReferenceGenerator(
            $this->getSequenceNumberFacade(),
            $this->getStoreFacade(),
            $this->getConfig()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\InvoiceExtension\Dependency\Plugin\InvoicePreSavePluginInterface]|
     */
    protected function getInvoicePreSavePlugins(): array
    {
        return $this->getProvidedDependency(InvoiceDependencyProvider::PLUGINS_PRE_SAVE);
    }

    /**
     * @return \FondOfSpryker\Zed\InvoiceExtension\Dependency\Plugin\InvoicePostSavePluginInterface[]
     */
    protected function getInvoicePostSavePlugins(): array
    {
        return $this->getProvidedDependency(InvoiceDependencyProvider::PLUGINS_POST_SAVE);
    }

    /**
     * @return \FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToSequenceNumberFacadeInterface
     */
    protected function getSequenceNumberFacade(): InvoiceToSequenceNumberFacadeInterface
    {
        return $this->getProvidedDependency(InvoiceDependencyProvider::FACADE_SEQUENCE_NUMBER);
    }

    /**
     * @return \FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToStoreFacadeInterface
     */
    protected function getStoreFacade(): InvoiceToStoreFacadeInterface
    {
        return $this->getProvidedDependency(InvoiceDependencyProvider::FACADE_STORE);
    }
}
