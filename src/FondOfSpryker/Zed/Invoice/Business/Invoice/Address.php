<?php

namespace FondOfSpryker\Zed\Invoice\Business\Invoice;

use FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToCountryInterface;
use FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToLocaleInterface;
use FondOfSpryker\Zed\Invoice\Persistence\InvoiceQueryContainerInterface;
use FondOfSpryker\Zed\Invoice\Persistence\InvoiceRepositoryInterface;
use Generated\Shared\Transfer\InvoiceAddressTransfer;
use Orm\Zed\Invoice\Persistence\FosInvoiceAddress;


class Address implements AddressInterface
{
    public const ADDRESS_TYPE_BILLING = 'billing';
    public const ADDRESS_TYPE_SHIPPING = 'shipping';

    /**
     * @var \FondOfSpryker\Zed\Invoice\Persistence\InvoiceQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @var \FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToCountryInterface
     */
    protected $countryFacade;

    /**
     * @var \FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToLocaleInterface
     */
    protected $localeFacade;

    /**
     * @var \FondOfSpryker\Zed\Invoice\Persistence\InvoiceRepositoryInterface 
     */
    protected $invoiceRepository;

    /**
     * Address constructor.
     *
     * @param \FondOfSpryker\Zed\Invoice\Persistence\InvoiceQueryContainerInterface $queryContainer
     * @param \FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToCountryInterface $countryFacade
     * @param \FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToLocaleInterface $localeFacade
     * @param \FondOfSpryker\Zed\Invoice\Persistence\InvoiceRepositoryInterface $invoiceRepository
     */
    public function __construct(
        InvoiceQueryContainerInterface $queryContainer,
        InvoiceToCountryInterface $countryFacade,
        InvoiceToLocaleInterface $localeFacade,
        InvoiceRepositoryInterface $invoiceRepository
    ) {
        $this->queryContainer = $queryContainer;
        $this->countryFacade = $countryFacade;
        $this->localeFacade = $localeFacade;
        $this->invoiceRepository = $invoiceRepository;
    }

    /**
     * @param \Generated\Shared\Transfer\InvoiceAddressTransfer $addressTransfer
     *
     * @return \Generated\Shared\Transfer\InvoiceAddressTransfer
     */
    public function createAddress(InvoiceAddressTransfer $addressTransfer)
    {
        $addressEntity = $this->createInvoiceAddress($addressTransfer);

        /*$addressTransfer->setIdCustomerAddress($addressEntity->getIdCustomerAddress());

        $this->updateCustomerDefaultAddresses($addressTransfer, $customerEntity);*/

        return $this->entityToAddressTransfer($addressEntity);
    }

    /**
     * @param \Generated\Shared\Transfer\InvoiceAddressTransfer $addressTransfer
     *
     * @return \Orm\Zed\Invoice\Persistence\FosInvoiceAddress
     */
    protected function createInvoiceAddress(InvoiceAddressTransfer $addressTransfer)
    {

        $addressEntity = new FosInvoiceAddress();
        $addressEntity->fromArray($addressTransfer->toArray());

        $fkCountry = $this->retrieveFkCountry($addressTransfer);
        $addressEntity->setFkCountry($fkCountry);

        $addressEntity->setCustomer($customer);
        $addressEntity->save();

        return $addressEntity;
    }

    /**
     * @param \Orm\Zed\Invoice\Persistence\FosInvoiceAddress $entity
     *
     * @return \Generated\Shared\Transfer\InvoiceAddressTransfer
     */
    protected function entityToAddressTransfer(FosInvoiceAddress $entity)
    {
        $addressTransfer = new InvoiceAddressTransfer();

        return $addressTransfer->fromArray($entity->toArray(), true);
    }
}
