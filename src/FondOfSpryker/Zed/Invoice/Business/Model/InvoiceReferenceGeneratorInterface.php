<?php

namespace FondOfSpryker\Zed\Invoice\Business\Model;

interface InvoiceReferenceGeneratorInterface
{
    /**
     * @return string
     */
    public function generate(): string;
}
