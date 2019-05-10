<?php

namespace FondOfSpryker\Zed\Invoice\Business\Invoice;

use FondOfSpryker\Shared\Invoice\Code\Messages;
use FondOfSpryker\Zed\Invoice\InvoiceConfig;
use FondOfSpryker\Zed\Invoice\Persistence\InvoiceQueryContainerInterface;
use Generated\Shared\Transfer\InvoiceErrorTransfer;
use Generated\Shared\Transfer\InvoiceResponseTransfer;
use Generated\Shared\Transfer\InvoiceTransfer;
use Orm\Zed\Invoice\Persistence\FosInvoice;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Locale\Persistence\LocaleQueryContainerInterface;


class Invoice implements InvoiceInterface
{
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
     * @param \FondOfSpryker\Zed\Invoice\Persistence\InvoiceQueryContainerInterface $queryContainer
     * @param \FondOfSpryker\Zed\Invoice\InvoiceConfig $InvoiceConfig
     * @param \Spryker\Zed\Locale\Persistence\LocaleQueryContainerInterface $localeQueryContainer
     * @param \Spryker\Shared\Kernel\Store $store
     * @param array $postInvoiceCreatePlugins
     */
    public function __construct(
        InvoiceQueryContainerInterface $queryContainer,
        InvoiceConfig $invoiceConfig,
        InvoiceValidatorInterface $invoiceValidator,
        LocaleQueryContainerInterface $localeQueryContainer,
        Store $store,
        array $postInvoiceCreatePlugins = []
    ) {
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

        $invoiceEntity->save();


       /* $invoiceTransfer->setCreatedAt($invoiceEntity->getCreatedAt()->format("Y-m-d H:i:s.u"));
        $invoiceTransfer->setUpdatedAt($invoiceEntity->getUpdatedAt()->format("Y-m-d H:i:s.u"));

        $invoiceResponseTransfer
            ->setIsSuccess(true)
            ->setInvoiceTransfer($invoiceTransfer);*/

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

}
