<?php

namespace FondOfSpryker\Zed\Invoice\Business\Invoice;

use FondOfSpryker\Zed\Invoice\Persistence\InvoiceQueryContainerInterface;
use Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface;

class InvoiceValidator implements InvoiceValidatorInterface
{
    /**
     * @var \Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface
     */
    protected $salesQueryContainer;

    /**
     * @var \FondOfSpryker\Zed\Invoice\Persistence\InvoiceQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * InvoiceValidator constructor.
     *
     * @param \FondOfSpryker\Zed\Invoice\Persistence\InvoiceQueryContainerInterface $queryContainer
     * @param \Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface $salesQueryContainer
     */
    public function __construct(
        InvoiceQueryContainerInterface $queryContainer,
        SalesQueryContainerInterface $salesQueryContainer
    )
    {
        $this->salesQueryContainer = $salesQueryContainer;
        $this->queryContainer = $queryContainer;

    }


    /**
     * @param string $orderReference
     *
     * @return bool
     */
    public function isOrderReferenceValid(string $orderReference): bool
    {
        $salesOrderEntity = $this->salesQueryContainer
            ->querySalesOrder()
            ->filterByOrderReference($orderReference)
            ->findOne();

        return ($salesOrderEntity !== null);
    }


}
