<?php

namespace FondOfSpryker\Zed\Invoice\Business\Invoice;

interface InvoiceValidatorInterface
{
    /**
     * @param string $orderReference
     *
     * @return bool
     */
    public function isOrderReferenceValid(string $orderReference): bool;
}
