<?php

namespace FondOfSpryker\Zed\Invoice\Business;

use FondOfSpryker\Zed\Invoice\Business\Invoice\Invoice;
use FondOfSpryker\Zed\Invoice\Business\Invoice\InvoiceReader;
use FondOfSpryker\Zed\Invoice\Business\Invoice\InvoiceReaderInterface;
use FondOfSpryker\Zed\Invoice\Business\Invoice\InvoiceValidator;
use FondOfSpryker\Zed\Invoice\Business\Model\Invoice\InvoiceHydrator;
use FondOfSpryker\Zed\Invoice\InvoiceDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\Invoice\InvoiceConfig getConfig()
 * @method \FondOfSpryker\Zed\Invoice\Persistence\InvoiceQueryContainerInterface getQueryContainer()
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
            $this->createInvoiceHydrator(),
            $this->getRepository()
        );
    }

    /**
     * @return \Spryker\Zed\Invoice\Business\Invoice\InvoiceInterface
     */
    public function createInvoice()
    {
        $config = $this->getConfig();

        $invoice = new Invoice(
            $this->getProductFacade(),
            $this->getSalesFacade(),
            $this->getCountryFacade(),
            $this->getQueryContainer(),
            $config,
            $this->createInvoiceValidator(),
            $this->getLocaleQueryContainer(),
            $this->getStore(),
            $this->getPostCustomerRegistrationPlugins()
        );

        return $invoice;
    }

    /**
     * @return \Spryker\Zed\Locale\Persistence\LocaleQueryContainerInterface
     */
    protected function getLocaleQueryContainer()
    {
        return $this->getProvidedDependency(InvoiceDependencyProvider::QUERY_CONTAINER_LOCALE);
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    protected function getStore()
    {
        return $this->getProvidedDependency(InvoiceDependencyProvider::STORE);
    }

    /**
     * @return \FondOfSpryker\Zed\InvoiceExtension\Dependency\Plugin\PostInvoiceRegistrationPluginInterface[]
     */
    protected function getPostCustomerRegistrationPlugins()
    {
        return $this->getProvidedDependency(InvoiceDependencyProvider::PLUGINS_POST_INVOICE_CREATE);
    }

    /**
     * @return \Spryker\Zed\Customer\Business\Customer\EmailValidatorInterface
     */
    protected function createInvoiceValidator()
    {
        return new InvoiceValidator(
            $this->getQueryContainer(),
            $this->getSalesQueryContainer()
        );
    }

    /**
     * @return \Spryker\Zed\Sales\Business\Model\Order\OrderHydratorInterface
     */
    public function createInvoiceHydrator()
    {
        return new InvoiceHydrator(
            $this->getQueryContainer()
        );
    }

    /**
     * @return \Spryker\Zed\Sales\Persistence\LocaleQueryContainerInterface
     */
    protected function getSalesQueryContainer()
    {
        return $this->getProvidedDependency(InvoiceDependencyProvider::QUERY_CONTAINER_SALES);
    }

    /**
     * @return \FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToCountryInterface
     */
    protected function getCountryFacade()
    {
        return $this->getProvidedDependency(InvoiceDependencyProvider::FACADE_COUNTRY);
    }

    /**
     * @return \FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToProductInterface
     */
    protected function getProductFacade()
    {
        return $this->getProvidedDependency(InvoiceDependencyProvider::FACADE_PRODUCT);
    }

    /**
     * @return \FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToSalesInterface
     */
    protected function getSalesFacade()
    {
        return $this->getProvidedDependency(InvoiceDependencyProvider::FACADE_SALES);
    }
}
