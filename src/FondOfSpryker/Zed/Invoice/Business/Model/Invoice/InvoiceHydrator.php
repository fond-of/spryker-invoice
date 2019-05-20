<?php

namespace FondOfSpryker\Zed\Invoice\Business\Model\Invoice;

use FondOfSpryker\Zed\Invoice\Persistence\InvoiceQueryContainerInterface;
use Generated\Shared\Transfer\CountryTransfer;
use Generated\Shared\Transfer\InvoiceAddressTransfer;
use Generated\Shared\Transfer\InvoiceItemTransfer;
use Generated\Shared\Transfer\InvoicePaymentTransfer;
use Generated\Shared\Transfer\InvoiceTransfer;
use mysql_xdevapi\Exception;
use Orm\Zed\Country\Persistence\SpyCountry;
use Orm\Zed\Invoice\Persistence\Base\FosInvoiceItem;
use Orm\Zed\Invoice\Persistence\FosInvoice;
use Propel\Runtime\ActiveQuery\Criteria;

class InvoiceHydrator implements InvoiceHydratorInterface
{
    /**
     * @var \FondOfSpryker\Zed\Invoice\Persistence\InvoiceQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * InvoiceHydrator constructor.
     *
     * @param \FondOfSpryker\Zed\Invoice\Persistence\InvoiceQueryContainerInterface $queryContainer
     */
    public function __construct(
        InvoiceQueryContainerInterface $queryContainer
    ) {
        $this->queryContainer = $queryContainer;
    }


    /**
     * @param \Orm\Zed\Invoice\Persistence\FosInvoice $invoiceEntity
     * 
     * @return \Generated\Shared\Transfer\InvoiceTransfer
     */
    public function hydrateInvoiceTransferFromPersistenceByInvoice(FosInvoice $invoiceEntity): InvoiceTransfer
    {
        return $this->applyInvoiceTransferHydrators($invoiceEntity);
    }


    /**
     * @param \Orm\Zed\Invoice\Persistence\FosInvoice $invoiceEntity
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer
     */
    protected function applyInvoiceTransferHydrators(FosInvoice $invoiceEntity): InvoiceTransfer
    {
        $invoiceTransfer = $this->hydrateBaseInvoiceTransfer($invoiceEntity);
        $this->hydrateBillingAddressToInvoiceTransfer($invoiceEntity, $invoiceTransfer);
        $this->hydrateShippingAddressToInvoiceTransfer($invoiceEntity, $invoiceTransfer);
        $this->hydrateInvoiceItemsToInvoiceTransfer($invoiceEntity, $invoiceTransfer);
        $this->hydratePaymentToInvoiceTransfer($invoiceEntity, $invoiceTransfer);

        /*$orderTransfer = $this->executeHydrateInvoicePlugins($invoiceTransfer);*/

        return $invoiceTransfer;
    }

    /**
     * @param \Orm\Zed\Invoice\Persistence\FosInvoice $invoiceEntity
     *
     * @return \Generated\Shared\Transfer\InvoiceTransfer
     */
    public function hydrateBaseInvoiceTransfer(FosInvoice $invoiceEntity): InvoiceTransfer
    {
        $invoiceTransfer = new InvoiceTransfer();
        $invoiceTransfer->fromArray($invoiceEntity->toArray(), true);

        return $invoiceTransfer;
    }

    /**
     * @param \Orm\Zed\Invoice\Persistence\FosInvoice $invoiceEntity
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @throws 
     */
    protected function hydrateBillingAddressToInvoiceTransfer(FosInvoice $invoiceEntity, InvoiceTransfer $invoiceTransfer): void
    {
        $countryEntity = $invoiceEntity->getBillingAddress()->getCountry();
        
        $billingAddressTransfer = new InvoiceAddressTransfer();
        $billingAddressTransfer->fromArray($invoiceEntity->getBillingAddress()->toArray(), true);
        $this->hydrateCountryEntityIntoAddressTransfer($billingAddressTransfer, $countryEntity);

        $invoiceTransfer->setBillingAddress($billingAddressTransfer);
    }

    /**
     * @param \Orm\Zed\Invoice\Persistence\FosInvoice $invoiceEntity
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @throws
     */
    protected function hydrateShippingAddressToInvoiceTransfer(FosInvoice $invoiceEntity, InvoiceTransfer $invoiceTransfer): void
    {
        $countryEntity = $invoiceEntity->getShippingAddress()->getCountry();

        $shippingAddressTransfer = new InvoiceAddressTransfer();
        $shippingAddressTransfer->fromArray($invoiceEntity->getShippingAddress()->toArray(), true);
        $this->hydrateCountryEntityIntoAddressTransfer($shippingAddressTransfer, $countryEntity);

        $invoiceTransfer->setShippingAddress($shippingAddressTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\InvoiceAddressTransfer $addressTransfer
     * @param \Orm\Zed\Country\Persistence\SpyCountry $countryEntity
     */
    protected function hydrateCountryEntityIntoAddressTransfer(InvoiceAddressTransfer $addressTransfer, SpyCountry $countryEntity): void
    {
        $countryTransfer = (new CountryTransfer())->fromArray($countryEntity->toArray(), true);
        $addressTransfer->setCountry($countryTransfer);
    }

    /**
     * @param \Orm\Zed\Invoice\Persistence\FosInvoice $invoiceEntity
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     *
     * @throws
     */
    public function hydrateInvoiceItemsToInvoiceTransfer(FosInvoice $invoiceEntity, InvoiceTransfer $invoiceTransfer): void
    {
        foreach ($invoiceEntity->getItems() as $invoiceItemEntity) {
            $itemTransfer = $this->hydrateInvoiceItemTransfer($invoiceItemEntity);
            $invoiceTransfer->addInvoiceItem($itemTransfer);
        }

    }

    /**
     * @param \Orm\Zed\Invoice\Persistence\Base\FosInvoiceItem $invoiceItemEntity
     *
     * @return \Generated\Shared\Transfer\InvoiceItemTransfer
     */
    protected function hydrateInvoiceItemTransfer(FosInvoiceItem $invoiceItemEntity): InvoiceItemTransfer
    {
        $itemTransfer = new InvoiceItemTransfer();
        $itemTransfer->fromArray($invoiceItemEntity->toArray(), true);

        return $itemTransfer;
    }

    /**
     * @param \Orm\Zed\Invoice\Persistence\FosInvoice $invoiceEntity
     * @param \Generated\Shared\Transfer\InvoiceTransfer $invoiceTransfer
     */
    public function hydratePaymentToInvoiceTransfer(FosInvoice $invoiceEntity, InvoiceTransfer $invoiceTransfer): void
    {
        $invoicePaymentTransfer = new InvoicePaymentTransfer();
        $invoicePaymentTransfer->setCode($invoiceEntity->getPaymentMethod());

        $invoiceTransfer->setPayment($invoicePaymentTransfer);

    }




}

