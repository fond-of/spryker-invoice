<?php

namespace FondOfSpryker\Zed\Invoice\Dependency\Facade;

use Generated\Shared\Transfer\LocaleTransfer;

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

    /**
     * @param int $idLocale
     *
     * @return \Generated\Shared\Transfer\LocaleTransfer
     *
     * @throws
     */
    public function getLocaleByIdLocale(int $idLocale): LocaleTransfer
    {
        return $this->localeFacade->getLocaleById($idLocale);
    }


}
