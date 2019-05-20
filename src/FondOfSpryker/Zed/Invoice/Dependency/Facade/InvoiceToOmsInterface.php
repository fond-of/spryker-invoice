<?php

namespace FondOfSpryker\Zed\Invoice\Dependency\Facade;

use Propel\Runtime\Collection\ObjectCollection;

interface InvoiceToOmsInterface
{
    /**
     * @param string $eventId
     * @param \Propel\Runtime\Collection\ObjectCollection $orderItems
     * @param array $logContext
     * @param array $data
     *
     * @return array
     */
    public function triggerEvent($eventId, ObjectCollection $orderItems, array $logContext, array $data = []);
}
