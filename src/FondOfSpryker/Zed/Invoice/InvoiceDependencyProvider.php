<?php

namespace FondOfSpryker\Zed\Invoice;

use FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToCountryBridge;
use FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToLocaleBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Kernel\Container;


/**
 * @method \FondOfSpryker\Zed\Invoice\InvoiceConfig getConfig()
 */
class InvoiceDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_COUNTRY = 'FACADE_COUNTRY';
    public const FACADE_LOCALE = 'FACADE_LOCALE';

    public const PLUGINS_POST_INVOICE_CREATE = 'PLUGINS_POST_INVOICE_CREATE';

    public const QUERY_CONTAINER_LOCALE = 'QUERY_CONTAINER_LOCALE';
    public const QUERY_CONTAINER_SALES = 'QUERY_CONTAINER_SALES';

    public const STORE = 'STORE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = $this->addCountryFacade($container);
        $container = $this->addLocaleQueryConainer($container);
        $container = $this->addSalesQueryConainer($container);
        $container = $this->addStore($container);
        $container = $this->addLocaleFacade($container);
        $container = $this->addPostInvoiceCreatePlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPostInvoiceCreatePlugins($container)
    {
        $container[static::PLUGINS_POST_INVOICE_CREATE] = function () {
            return $this->getPostInvoiceCreatePlugins();
        };

        return $container;
    }


    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStore(Container $container)
    {
        $container[static::STORE] = function (Container $container) {
            return Store::getInstance();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addLocaleFacade(Container $container)
    {
        $container[static::FACADE_LOCALE] = function (Container $container) {
            return new InvoiceToLocaleBridge($container->getLocator()->locale()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCountryFacade(Container $container): Container
    {
        $container[static::FACADE_COUNTRY] = function (Container $container) {
            return new InvoiceToCountryBridge($container->getLocator()->country()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addLocaleQueryConainer(Container $container): Container
    {
        $container[static::QUERY_CONTAINER_LOCALE] = function (Container $container) {
            return $container->getLocator()->locale()->queryContainer();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSalesQueryConainer(Container $container): Container
    {
        $container[static::QUERY_CONTAINER_SALES] = function (Container $container) {
            return $container->getLocator()->sales()->queryContainer();
        };

        return $container;
    }


    /**
     * @return \FondOfSpryker\Zed\InvoiceExtension\Dependency\Plugin\PostInvoiceCreatePluginInterface[]
     */
    protected function getPostInvoiceCreatePlugins(): array
    {
        return [];
    }

}
