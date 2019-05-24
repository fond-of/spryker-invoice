<?php

namespace FondOfSpryker\Zed\Invoice\Business\Invoice;

use ArrayObject;
use FondOfSpryker\Zed\Invoice\Business\Model\Invoice\InvoiceHydratorInterface;
use FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToLocaleInterface;
use FondOfSpryker\Zed\Invoice\Persistence\InvoiceEntityManagerInterface;
use FondOfSpryker\Zed\Invoice\Persistence\InvoiceRepositoryInterface;
use Generated\Shared\Transfer\InvoiceListTransfer;
use Generated\Shared\Transfer\InvoiceTransfer;
use Orm\Zed\Locale\Persistence\SpyLocale;
use Orm\Zed\Locale\Persistence\SpyLocaleQuery;
use Propel\Runtime\Collection\ObjectCollection;

class InvoiceReader implements InvoiceReaderInterface
{
    /**
     * @var \FondOfSpryker\Zed\Invoice\Persistence\InvoiceEntityManagerInterface
     */
    protected $invoiceEntityManager;

    /**
     * @var \FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToLocaleInterface
     */
    protected $localeFacade;

    /**
     * @var \FondOfSpryker\Zed\Invoice\Business\Model\Invoice\InvoiceHydratorInterface
     */
    protected $invoiceHydrator;

    /**
     * @var \FondOfSpryker\Zed\Invoice\Persistence\InvoiceRepositoryInterface
     */
    protected $invoiceRepository;

    /**
     * InvoiceReader constructor.
     *
     * @param \FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToLocaleInterface $invoiceToLocale
     * @param \FondOfSpryker\Zed\Invoice\Persistence\InvoiceEntityManagerInterface $invoiceEntityManager
     * @param \FondOfSpryker\Zed\Invoice\Business\Model\Invoice\InvoiceHydratorInterface $invoiceHydrator
     * @param \FondOfSpryker\Zed\Invoice\Persistence\InvoiceRepositoryInterface $invoiceRepository
     */
    public function __construct(
        InvoiceToLocaleInterface $localeFacade,
        InvoiceEntityManagerInterface $invoiceEntityManager,
        InvoiceHydratorInterface $invoiceHydrator,
        InvoiceRepositoryInterface $invoiceRepository
    ) {
        $this->invoiceEntityManager = $invoiceEntityManager;
        $this->invoiceHydrator = $invoiceHydrator;
        $this->invoiceRepository = $invoiceRepository;
        $this->localeFacade = $localeFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\InvoiceListTransfer $invoiceListTransfer
     * @param string $customerReference
     *
     * @return \Generated\Shared\Transfer\InvoiceListTransfer
     */
    public function findInvoicesByCustomerReference(InvoiceListTransfer $invoiceListTransfer, string $customerReference): InvoiceListTransfer
    {
        $invoiceCollection = $this->invoiceRepository->findInvoicesByCustomerReference($customerReference);
        $invoiceListCollection = $this->hydrateInvoiceListCollectionTransferFromEntityCollection($invoiceCollection);

        $invoiceListTransfer->setInvoices($invoiceListCollection);

        return $invoiceListTransfer;
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection $orderCollection
     *
     * @return \ArrayObject|\Generated\Shared\Transfer\OrderTransfer[]
     *
     * @throws 
     */
    protected function hydrateInvoiceListCollectionTransferFromEntityCollection(ObjectCollection $orderCollection): ArrayObject
    {
        $invoices = new ArrayObject();

        /** @var \Orm\Zed\Invoice\Persistence\Base\FosInvoice $invoiceEntity */
        foreach ($orderCollection as $invoiceEntity) {
            if ($invoiceEntity->countItems() === 0) {
                continue;
            }

            $invoiceTransfer = $this->invoiceHydrator->hydrateInvoiceTransferFromPersistenceByInvoice($invoiceEntity);
            $invoiceTransfer->setCurrency($invoiceEntity->getCurrencyIsoCode());
            $invoiceTransfer->setLocale(
                $this->localeFacade->getLocaleByIdLocale($invoiceEntity->getFkLocale())->getLocaleName()
            );

            $invoices->append($invoiceTransfer);
        }

        return $invoices;
    }
    
}
