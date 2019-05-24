<?php

namespace FondOfSpryker\Zed\Invoice\Business\Invoice;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\Invoice\Business\Model\Invoice\InvoiceHydratorInterface;
use FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToLocaleInterface;
use FondOfSpryker\Zed\Invoice\Persistence\InvoiceEntityManagerInterface;
use FondOfSpryker\Zed\Invoice\Persistence\InvoiceRepositoryInterface;
use Orm\Zed\Invoice\Persistence\FosInvoice;
use Orm\Zed\Invoice\Persistence\FosInvoiceItem;
use Propel\Runtime\Collection\ObjectCollection;

class InvoiceReaderTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\Invoice\Persistence\InvoiceEntityManagerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $invoiceEntityManagerMock;

    /**
     * @var \FondOfSpryker\Zed\Invoice\Business\Model\Invoice\InvoiceHydratorInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $invoiceHydratorMock;

    /**
     * @var \Generated\Shared\Transfer\InvoiceTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $invoiceTransferMock;

    /**
     * @var \Generated\Shared\Transfer\InvoiceListTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $invoiceListTransferMock;

    /**
     * @var \FondOfSpryker\Zed\Invoice\Business\Invoice\InvoiceReaderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $invoiceReader;

    /**
     * @var \FondOfSpryker\Zed\Invoice\Persistence\InvoiceRepositoryInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $invoiceRepositoryMock;

    /**
     * @var \FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToLocaleInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $localFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\LocaleTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $localeTransferMock;

    /**
     *
     * @throws
     */
    protected function _before(): void
    {
        $this->invoiceEntityManagerMock = $this->getMockForAbstractClass(InvoiceEntityManagerInterface::class);
        $this->invoiceRepositoryMock = $this->getMockForAbstractClass(InvoiceRepositoryInterface::class);
        $this->localFacadeMock = $this->getMockForAbstractClass(InvoiceToLocaleInterface::class);

        $this->localeTransferMock = $this->getMockBuilder('\Generated\Shared\Transfer\LocaleTransfer')
            ->disableOriginalConstructor()
            ->setMethods(['getLocaleName'])
            ->getMock();

        $this->invoiceHydratorMock = $this->getMockBuilder(InvoiceHydratorInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['hydrateInvoiceTransferFromPersistenceByInvoice'])
            ->getMock();

        $this->invoiceTransferMock = $this->getMockBuilder('\Generated\Shared\Transfer\InvoiceTransfer')
            ->disableOriginalConstructor()
            ->getMock();

        $this->invoiceListTransferMock = $this->getMockBuilder('\Generated\Shared\Transfer\InvoiceListTransfer')
            ->disableOriginalConstructor()
            ->setMethods(['getInvoices','setInvoices'])
            ->getMock();



        $this->invoiceReader = new InvoiceReader(
            $this->localFacadeMock,
            $this->invoiceEntityManagerMock,
            $this->invoiceHydratorMock,
            $this->invoiceRepositoryMock
        );

    }

    /**
     * @return void
     */
    public function testFindInvoicesByCustomerReference(): void
    {
        $customerReference = 'CUSTOMER--1';

        $invoiceItemCollection = new ObjectCollection();
        $invoiceItemCollection->setModel(FosInvoiceItem::class);
        $invoiceItemCollection->fromArray(
            [
                0 => [
                    "id_invoice_item" => 1,
                    "fk_invoice" => 1,
                    "fk_product_abstract" => 1,
                    "fk_product"=> 1,
                    "sku" => "SKU-1",
                    "name" => "Test Product",
                    "quantity"=> 2,
                    "gross_price"=> 3490,
                    "net_price" => 0,
                    "tax_amount"=> null,
                    "canceled_amount" => null,
                    "refundable_amount"=> 0,
                    "subtotal_aggregation"=> 0,
                    "tax_amount_full_aggregation"=> 0,
                    "quantity_invoiced"=> 0,
                    "quantity_shipped"=> 0,
                    "discount_type" => "",
                    "discount_amount" => 0,
                    "shipment_date"=> "2019-10-02",
                    "position"=> 1

                ]
            ]
        );

        $invoiceCollection = new ObjectCollection();
        $invoiceCollection->setModel(FosInvoice::class);
        $invoiceCollection->fromArray(
            [
                0 => [
                    'id_invoice' => 40,
                    'fk_sales_order' => 60,
                    'order_reference' => 'SALES_ORDER--1',
                    'customer_reference' => 'CUSTOMER--1',
                    'fk_invoice_address_billing' => 1,
                    'fk_invoice_address_shipping' => 1,
                    'payment_method' => 'invoice',
                    'fk_locale' => 1,
                    'currency_iso_code' => 'EUR',
                    'store' => 'DEFAULT',
                    'created_at' => '',
                    'updated_at' =>  ''

                ]
            ]
        );

        $invoiceCollection->getFirst()->setItems($invoiceItemCollection);

        $this->invoiceRepositoryMock->expects($this->atLeastOnce())
            ->method('findInvoicesByCustomerReference')
            ->willReturn($invoiceCollection);

        $this->localFacadeMock
            ->expects($this->any())
            ->method('getLocaleByIdLocale')
            ->willReturn($this->localeTransferMock);

        $this->localeTransferMock
            ->expects($this->atLeastOnce())
            ->method('getLocaleName')
            ->willReturn('en_US');

        $this->invoiceHydratorMock->expects($this->atLeastOnce())
            ->method('hydrateInvoiceTransferFromPersistenceByInvoice')
            ->willReturn($this->invoiceTransferMock);

        $this->invoiceListTransferMock
            ->expects($this->atLeastOnce())
            ->method('getInvoices')
            ->willReturn($invoiceCollection);

        $invoiceListTransfer = $this->invoiceReader->findInvoicesByCustomerReference($this->invoiceListTransferMock, $customerReference);

        $this->assertInstanceOf('\Generated\Shared\Transfer\InvoiceListTransfer', $invoiceListTransfer);
        $this->assertNotEmpty($invoiceListTransfer->getInvoices());
        $this->assertEquals(1, count($invoiceListTransfer->getInvoices()));

    }

}