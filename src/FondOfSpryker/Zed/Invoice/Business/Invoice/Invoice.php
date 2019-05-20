<?php

namespace FondOfSpryker\Zed\Invoice\Business\Invoice;

use FondOfSpryker\Shared\Invoice\Code\Messages;
use FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToCountryInterface;
use FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToProductInterface;
use FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToSalesInterface;
use FondOfSpryker\Zed\Invoice\InvoiceConfig;
use FondOfSpryker\Zed\Invoice\Persistence\InvoiceQueryContainerInterface;
use Generated\Shared\Transfer\InvoiceAddressTransfer;
use Generated\Shared\Transfer\InvoiceErrorTransfer;
use Generated\Shared\Transfer\InvoiceItemTransfer;
use Generated\Shared\Transfer\InvoiceResponseTransfer;
use Generated\Shared\Transfer\InvoiceTransfer;
use Orm\Zed\Invoice\Persistence\FosInvoice;
use Orm\Zed\Invoice\Persistence\FosInvoiceAddress;
use Orm\Zed\Invoice\Persistence\FosInvoiceItem;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Locale\Persistence\LocaleQueryContainerInterface;


class Invoice implements InvoiceInterface
{
    /**
     * @var \FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToProductInterface
     */
    protected $productFacade;

    /**
     * @var \FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToSalesInterface
     */
    protected $salesFacade;

    /**
     * @var \FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToCountryInterface
     */
    protected $countryFacade;

    /**
     * @var \FondOfSpryker\Zed\Invoice\Persistence\InvoiceQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @var \FondOfSpryker\Zed\Invoice\InvoiceConfig
     */
    protected $invoiceConfig;

    /**
     * @var \FondOfSpryker\Zed\Invoice\Business\Invoice\InvoiceValidatorInterface
     */
    protected $invoiceValidator;

    /**
     * @var \Spryker\Zed\Locale\Persistence\LocaleQueryContainerInterface
     */
    protected $localeQueryContainer;

    /**
     * @var \Spryker\Shared\Kernel\Store
     */
    protected $store;

    /**
     * @var \FondOfSpryker\Zed\InvoiceExtension\Dependency\Plugin\PostInvoiceCreatePluginInterface[]
     */
    protected $postInvoiceCreatePlugins;

    /**
     * Invoice constructor.
     *
     * @param \FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToCountryInterface $countryFacade
     * @param \FondOfSpryker\Zed\Invoice\Persistence\InvoiceQueryContainerInterface $queryContainer
     * @param \FondOfSpryker\Zed\Invoice\InvoiceConfig $invoiceConfig
     * @param \FondOfSpryker\Zed\Invoice\Business\Invoice\InvoiceValidatorInterface $invoiceValidator
     * @param \Spryker\Zed\Locale\Persistence\LocaleQueryContainerInterface $localeQueryContainer
     * @param \Spryker\Shared\Kernel\Store $store
     * @param array $postInvoiceCreatePlugins
     */
    public function __construct(
        InvoiceToProductInterface $productFacade,
        InvoiceToSalesInterface $salesFacade,
        InvoiceToCountryInterface $countryFacade,
        InvoiceQueryContainerInterface $queryContainer,
        InvoiceConfig $invoiceConfig,
        InvoiceValidatorInterface $invoiceValidator,
        LocaleQueryContainerInterface $localeQueryContainer,
        Store $store,
        array $postInvoiceCreatePlugins = []
    ) {
        $this->countryFacade = $countryFacade;
        $this->productFacade = $productFacade;
        $this->salesFacade = $salesFacade;
        $this->queryContainer = $queryContainer;
        $this->invoiceConfig = $invoiceConfig;
        $this->invoiceValidator = $invoiceValidator;
        $this->localeQueryContainer = $localeQueryContainer;
        $this->store = $store;
        $this->postInvoiceCreatePlugins = $postInvoiceCreatePlugins;
    }


    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceResponseTransfer
     */
    public function create(InvoiceTransfer $invoiceTransfer)
    {
        $invoiceResponseTransfer = $this->add($invoiceTransfer);

        if (!$invoiceResponseTransfer->getIsSuccess()) {
            return $invoiceResponseTransfer;
        }

        return $invoiceResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceResponseTransfer
     */
    public function add($invoiceTransfer)
    {
        $invoiceEntity = new FosInvoice();
        $invoiceEntity->fromArray($invoiceTransfer->toArray());

        $invoiceResponseTransfer = $this->createInvoiceResponseTransfer();
        $invoiceResponseTransfer = $this->validateOrderReference($invoiceResponseTransfer, $invoiceEntity);

        if ($invoiceResponseTransfer->getIsSuccess() !== true) {
            return $invoiceResponseTransfer;
        }

        $this->saveInvoiceTransaction($invoiceTransfer);


        $invoiceResponseTransfer
            ->setIsSuccess(true)
            ->setInvoiceTransfer($invoiceTransfer);

        return $invoiceResponseTransfer;
    }

    /**
     * @param bool $isSuccess
     *
     * @return \Generated\Shared\Transfer\InvoiceResponseTransfer
     */
    protected function createInvoiceResponseTransfer($isSuccess = true)
    {
        $invoiceResponseTransfer = new InvoiceResponseTransfer();
        $invoiceResponseTransfer->setIsSuccess($isSuccess);

        return $invoiceResponseTransfer;
    }

    /**
     * @param string $message
     *
     * @return \Generated\Shared\Transfer\CustomerErrorTransfer
     */
    protected function createErrorInvoiceResponseTransfer($message)
    {
        $invoiceErrorTransfer = new InvoiceErrorTransfer();
        $invoiceErrorTransfer->setMessage($message);

        return $invoiceErrorTransfer;
    }


    /**
     * @param \Generated\Shared\Transfer\InvoiceResponseTransfer $invoiceResponseTransfer
     * @param \Orm\Zed\Customer\Persistence\SpySale $saleEntity
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    protected function validateOrderReference(InvoiceResponseTransfer $invoiceResponseTransfer, FosInvoice $invoiceEntity)
    {
        if (!$this->invoiceValidator->isOrderReferenceValid($invoiceEntity->getOrderReference())) {
            $invoiceResponseTransfer = $this->addErrorToInvoiceResponseTransfer(
                $invoiceResponseTransfer,
                Messages::SALES_ORDER_REFERENCE_NOT_FOUND
            );
        }

        return $invoiceResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\InvoiceResponseTransfer $invoiceResponseTransfer
     * @param string $message
     *
     * @return \Generated\Shared\Transfer\InvoiceResponseTransfer
     */
    protected function addErrorToInvoiceResponseTransfer(InvoiceResponseTransfer $invoiceResponseTransfer, string $message): InvoiceResponseTransfer
    {
        $invoiceResponseTransfer->setIsSuccess(false);
        $invoiceResponseTransfer->addError(
            $this->createErrorInvoiceResponseTransfer($message)
        );

        return $invoiceResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Orm\Zed\Invoice\Persistence\FosInvoice
     */
    protected function saveInvoiceTransaction(InvoiceTransfer $invoiceTransfer)
    {
        $invoiceEntity = $this->saveInvoiceEntity($invoiceTransfer);

        $this->saveInvoiceItems($invoiceTransfer, $invoiceEntity);

        return $invoiceEntity;
    }

    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return \Orm\Zed\Invoice\Persistence\FosInvoice
     */
    protected function saveInvoiceEntity(InvoiceTransfer $invoiceTransfer)
    {
        $invoiceEntity = $this->createInvoiceEntity();
        $this->hydrateAddresses($invoiceTransfer, $invoiceEntity);
        $this->hydrateInvoiceEntity($invoiceTransfer, $invoiceEntity);

        $invoiceEntity->save();

        return $invoiceEntity;
    }

    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     * @param \Orm\Zed\Invoice\Persistence\FosInvoice $invoiceEntity
     *
     * @throws
     */
    protected function hydrateAddresses(InvoiceTransfer $invoiceTransfer, FosInvoice $invoiceEntity): void
    {
        $billingAddressEntity = $this->saveInvoiceAddress($invoiceTransfer->getBillingAddress(), Address::ADDRESS_TYPE_BILLING);
        $shippingAddressEntity = $this->saveInvoiceAddress($invoiceTransfer->getShippingAddress(),Address::ADDRESS_TYPE_SHIPPING);

        $invoiceEntity->setBillingAddress($billingAddressEntity);
        $invoiceEntity->setShippingAddress($shippingAddressEntity);
    }


    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     * @param \Orm\Zed\Invoice\Persistence\FosInvoice $invoiceEntity
     *
     * @throws
     */
    protected function hydrateInvoiceEntity(InvoiceTransfer $invoiceTransfer, FosInvoice $invoiceEntity): void
    {
        $invoiceEntity->setFkSalesOrder($this->getIdSalesOrder($invoiceTransfer->getOrderReference()));
        $invoiceEntity->setOrderReference($invoiceTransfer->getOrderReference());
        $invoiceEntity->setCustomerReference($invoiceTransfer->getCustomerReference());
        $invoiceEntity->setFkInvoiceAddressBilling($invoiceEntity->getBillingAddress()->getIdInvoiceAddress());
        $invoiceEntity->setFkInvoiceAddressShipping($invoiceEntity->getShippingAddress()->getIdInvoiceAddress());
        $invoiceEntity->setPaymentMethod($invoiceTransfer->getPayment()->getCode());
        $invoiceEntity->setStore($invoiceTransfer->getStore());
        $invoiceEntity->setFkLocale($this->getIdLocale($invoiceTransfer));
        $invoiceEntity->setCurrencyIsoCode($invoiceTransfer->getCurrency());
    }


    /**
     * @param \Generated\Shared\Transfer\InvoiceAddressTransfer $addressTransfer
     *
     * @return \Orm\Zed\Invoice\Persistence\FosInvoiceAddress
     */
    protected function saveInvoiceAddress(InvoiceAddressTransfer $addressTransfer, string $addressType)
    {
        $invoiceAddressEntity = $this->createInvoiceAddressEntity();
        $this->hydrateInvoiceAddress($addressTransfer, $invoiceAddressEntity, $addressType);
        $invoiceAddressEntity->save();

        $addressTransfer->setIdInvoiceAddress($invoiceAddressEntity->getIdInvoiceAddress());

        return $invoiceAddressEntity;
    }

    /**
     * @param \Generated\Shared\Transfer\InvoiceAddressTransfer $addressTransfer
     * @param \Orm\Zed\Invoice\Persistence\FosInvoiceAddress $invoiceAddressEntity
     * @param string $addressType
     *
     * @throws
     */

    protected function hydrateInvoiceAddress(InvoiceAddressTransfer $addressTransfer, FosInvoiceAddress $invoiceAddressEntity, string $addressType): void
    {
        $invoiceAddressEntity->fromArray($addressTransfer->toArray());

        $invoiceAddressEntity->setType($addressType);
        $invoiceAddressEntity->setFkCountry(
            $this->countryFacade->getCountryByIso2Code($addressTransfer->getCountry())->getIdCountry()
        );

        if ($addressTransfer->getRegion() != null) {
            $invoiceAddressEntity->setFkRegion(
                $this->countryFacade->getIdRegionByIso2Code($addressTransfer->getRegion())
            );
        }
    }

    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     * @param \Orm\Zed\Invoice\Persistence\FosInvoice $invoiceEntity
     *
     * @throws
     */
    protected function saveInvoiceItems(InvoiceTransfer $invoiceTransfer, FosInvoice $invoiceEntity): void
    {

        foreach ($invoiceTransfer->getItems() as $itemTransfer) {
            $invoiceItemEntity = $this->createInvoiceItemEntity();
            $this->hydrateInvoiceItemEntity($invoiceEntity, $invoiceTransfer, $invoiceItemEntity, $itemTransfer);

            //$invoiceItemEntity = $this->executInvoiceItemExpanderPreSavePlugins($invoiceTransfer, $itemTransfer, $invoiceItemEntity);
            $invoiceItemEntity->save();
        }
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $salesOrderEntity
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $salesOrderItemEntity
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return void
     */
    protected function hydrateInvoiceItemEntity(
        FosInvoice $invoiceEntity,
        InvoiceTransfer $invoiceTransfer,
        FosInvoiceItem $invoiceItemEntity,
        InvoiceItemTransfer $itemTransfer
    ) {
        $invoiceItemEntity->fromArray($itemTransfer->toArray());


        $invoiceItemEntity->setFkInvoice($invoiceEntity->getIdInvoice());
        $invoiceItemEntity->setFkProductAbstract($this->getIdProductAbstractByConcreteSku($itemTransfer->getSku()));
        $invoiceItemEntity->setFkProduct($this->getIdProductConcreteBySku($itemTransfer->getSku()));

        /*$invoiceItemEntity->setFkOmsInvoiceItemState($initialStateEntity->getIdOmsInvoiceItemState());

        $invoiceItemEntity->setProcess($processEntity);*/
    }

    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return int
     */
    protected function getIdLocale(InvoiceTransfer $invoiceTransfer): int
    {
        $localeName = $invoiceTransfer->getLocale();
        $localeEntity = $this->localeQueryContainer->queryLocaleByName($localeName)->findOne();

        return $localeEntity->getIdLocale();
    }

    /**
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @return int
     */
    protected function getIdSalesOrder(string $orderReference): int
    {
        $salesOrderEntity = $this->salesFacade->findSalesOrderByOrderReference($orderReference);

        if ($salesOrderEntity === null) {
            return null;
        }

        return $salesOrderEntity->getIdSalesOrder();
    }

    /**
     * @param string $sku
     *
     * @return int
     */
    protected function getIdProductAbstractByConcreteSku(string $sku): int
    {
        return $this->productFacade->findIdProductAbstactByConcreteSku($sku);
    }

    /**
     * @param string $sku
     * 
     * @return int
     */
    protected function getIdProductConcreteBySku(string $sku): int
    {
        return $this->productFacade->findProductConcreteIdBySku($sku);
    }

    /**
     * @return \Orm\Zed\Invoice\Persistence\FosInvoice
     */
    protected function createInvoiceEntity()
    {
        return new FosInvoice();
    }

    /**
     * @return \Orm\Zed\Invoice\Persistence\FosInvoiceAddress
     */
    protected function createInvoiceAddressEntity()
    {
        return new FosInvoiceAddress();
    }

    /**
     * @return \Orm\Zed\Invoice\Persistence\FosInvoiceItem
     */
    protected function createInvoiceItemEntity()
    {
        return new FosInvoiceItem();
    }

}