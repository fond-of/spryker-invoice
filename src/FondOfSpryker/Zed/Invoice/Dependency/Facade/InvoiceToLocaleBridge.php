<?php

namespace FondOfSpryker\Zed\Invoice\Dependency\Facade;

class InvoiceToLocaleBridge implements InvoiceToLocaleInterface
{
    /**
     * @var \Spryker\Zed\Locale\Business\LocaleFacadeInterface
     */
    protected $localeFacade;

    /**
     * @param \Spryker\Zed\Locale\Business\LocaleFacadeInterface $localeFacade
     */
    public function __construct($localeFacade)
    {
        $this->localeFacade = $localeFacade;
    }

}
