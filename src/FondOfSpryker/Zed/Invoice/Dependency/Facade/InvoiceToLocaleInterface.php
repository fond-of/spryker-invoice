<?php

namespace FondOfSpryker\Zed\Invoice\Dependency\Facade;

use Generated\Shared\Transfer\LocaleTransfer;

interface InvoiceToLocaleInterface
{

    /**
     * @param int $idLocale
     *
     * @return \Generated\Shared\Transfer\LocaleTransfer
     */
    public function getLocaleByIdLocale(int $idLocale): LocaleTransfer;
}
