<?php

namespace FondOfSpryker\Zed\Invoice\Communication\Plugin\Oms\Condition;

use Generated\Shared\Transfer\InvoiceTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use Spryker\Zed\Kernel\Communication\AbstractPlugin as BaseAbstractPlugin;
use Spryker\Zed\Oms\Communication\Plugin\Oms\Condition\ConditionInterface;

abstract class AbstractPlugin extends BaseAbstractPlugin implements ConditionInterface
{
    const NAME = 'AbstractPlugin';

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItem
     *
     * @return bool
     */
    public function check(SpySalesOrderItem $orderItem)
    {
        $invoiceTransfer = new InvoiceTransfer();

        $isSuccess = $this->callFacade($invoiceTransfer);

        return $isSuccess;
    }

    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return bool
     */
    abstract protected function callFacade(InvoiceTransfer $invoiceTransfer);

    /**
     * @return string
     */
    protected function getName()
    {
        return self::NAME;
    }
}
