<?php

namespace FondOfSpryker\Zed\Invoice\Business\TransactionStatus;

interface TransactionStatusUpdateManagerInterface
{

    /**
     * @param $idSalesOrder
     * @param $idSalesOrderItem
     *
     * @return bool
     */
    public function isInvoiceAppointed($idSalesOrder, $idSalesOrderItem): bool;

}