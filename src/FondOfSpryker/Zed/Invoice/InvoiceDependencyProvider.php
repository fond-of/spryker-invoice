<?php

namespace FondOfSpryker\Zed\Invoice;

use FondOfSpryker\Zed\Invoice\Communication\Plugin\InvoiceExtension\AddressInvoicePreSavePlugin;
use FondOfSpryker\Zed\Invoice\Communication\Plugin\InvoiceExtension\ItemsInvoicePostSavePlugin;
use FondOfSpryker\Zed\Invoice\Communication\Plugin\InvoiceExtension\ReferenceInvoicePreSavePlugin;
use FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToSequenceNumberFacadeBridge;
use FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToStoreFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @method \FondOfSpryker\Zed\Invoice\InvoiceConfig getConfig()
 */
class InvoiceDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_SEQUENCE_NUMBER = 'FACADE_SEQUENCE_NUMBER';
    public const FACADE_STORE = 'FACADE_STORE';

    public const PLUGINS_POST_SAVE = 'PLUGINS_POST_SAVE';
    public const PLUGINS_PRE_SAVE = 'PLUGINS_PRE_SAVE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addSequenceNumberFacade($container);
        $container = $this->addStoreFacade($container);

        $container = $this->addInvoicePreSavePlugins($container);
        $container = $this->addInvoicePostSavePlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSequenceNumberFacade(Container $container): Container
    {
        $container[static::FACADE_SEQUENCE_NUMBER] = static function (Container $container) {
            return new InvoiceToSequenceNumberFacadeBridge(
                $container->getLocator()->sequenceNumber()->facade()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStoreFacade(Container $container): Container
    {
        $container[static::FACADE_STORE] = static function (Container $container) {
            return new InvoiceToStoreFacadeBridge(
                $container->getLocator()->store()->facade()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addInvoicePreSavePlugins(Container $container): Container
    {
        $self = $this;

        $container[static::PLUGINS_PRE_SAVE] = static function () use ($self) {
            return $self->getInvoicePreSavePlugins();
        };

        return $container;
    }

    /**
     * @return \FondOfSpryker\Zed\InvoiceExtension\Dependency\Plugin\InvoicePreSavePluginInterface[]
     */
    protected function getInvoicePreSavePlugins(): array
    {
        return [
            new AddressInvoicePreSavePlugin(),
            new ReferenceInvoicePreSavePlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addInvoicePostSavePlugins(Container $container): Container
    {
        $self = $this;

        $container[static::PLUGINS_POST_SAVE] = static function () use ($self) {
            return $self->getInvoicePostSavePlugins();
        };

        return $container;
    }

    /**
     * @return \FondOfSpryker\Zed\InvoiceExtension\Dependency\Plugin\InvoicePostSavePluginInterface[]
     */
    protected function getInvoicePostSavePlugins(): array
    {
        return [
            new ItemsInvoicePostSavePlugin(),
        ];
    }
}
