<?php

namespace FondOfSpryker\Zed\Invoice\Dependency\Facade;

use Generated\Shared\Transfer\OrderTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;

class InvoiceToSalesBridge implements InvoiceToSalesInterface
{
    /**
     * @var \FondOfSpryker\Zed\Sales\Business\SalesFacadeInterface
     */
    protected $salesFacade;

    /**
     * @param \FondOfSpryker\Zed\Sales\Business\SalesFacadeInterface $salesFacade
     */
    public function __construct($salesFacade)
    {
        $this->salesFacade = $salesFacade;
    }

    /**
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function findSalesOrderByOrderReference(string $orderReference): OrderTransfer
    {
        return $this->salesFacade->findSalesOrderByOrderReference($orderReference);
    }

}
