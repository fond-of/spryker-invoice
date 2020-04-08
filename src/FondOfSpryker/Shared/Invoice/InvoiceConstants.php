<?php

namespace FondOfSpryker\Shared\Invoice;

use Spryker\Shared\SequenceNumber\SequenceNumberConstants;

interface InvoiceConstants
{
    public const REFERENCE_NAME_VALUE = 'InvoiceReference';
    public const REFERENCE_PREFIX = 'INVOICE:REFERENCE_PREFIX';
    public const REFERENCE_ENVIRONMENT_PREFIX = SequenceNumberConstants::ENVIRONMENT_PREFIX;
    public const REFERENCE_OFFSET = 'INVOICE:REFERENCE_OFFSET';
}
