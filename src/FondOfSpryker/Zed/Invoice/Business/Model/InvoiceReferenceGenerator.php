<?php

namespace FondOfSpryker\Zed\Invoice\Business\Model;

use FondOfSpryker\Shared\Invoice\InvoiceConstants;
use FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToSequenceNumberFacadeInterface;
use FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToStoreFacadeInterface;
use FondOfSpryker\Zed\Invoice\InvoiceConfig;
use Generated\Shared\Transfer\SequenceNumberSettingsTransfer;

class InvoiceReferenceGenerator implements InvoiceReferenceGeneratorInterface
{
    protected const UNIQUE_IDENTIFIER_SEPARATOR = '-';

    /**
     * @var \FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToSequenceNumberFacadeInterface
     */
    protected $sequenceNumberFacade;

    /**
     * @var \FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToStoreFacadeInterface
     */
    protected $storeFacade;

    /**
     * @var \FondOfSpryker\Zed\Invoice\InvoiceConfig
     */
    protected $config;

    /**
     * @param \FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToSequenceNumberFacadeInterface $sequenceNumberFacade
     * @param \FondOfSpryker\Zed\Invoice\Dependency\Facade\InvoiceToStoreFacadeInterface $storeFacade
     * @param \FondOfSpryker\Zed\Invoice\InvoiceConfig $config
     */
    public function __construct(
        InvoiceToSequenceNumberFacadeInterface $sequenceNumberFacade,
        InvoiceToStoreFacadeInterface $storeFacade,
        InvoiceConfig $config
    ) {
        $this->sequenceNumberFacade = $sequenceNumberFacade;
        $this->storeFacade = $storeFacade;
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function generate(): string
    {
        $sequenceNumberSettingsTransfer = $this->getSequenceNumberSettingsTransfer();

        return $this->sequenceNumberFacade->generate($sequenceNumberSettingsTransfer);
    }

    /**
     * @return \Generated\Shared\Transfer\SequenceNumberSettingsTransfer
     */
    protected function getSequenceNumberSettingsTransfer(): SequenceNumberSettingsTransfer
    {
        $sequenceNumberSettingsTransfer = (new SequenceNumberSettingsTransfer())
            ->setName(InvoiceConstants::REFERENCE_NAME_VALUE)
            ->setPrefix($this->getSequenceNumberPrefix());

        if ($this->config->getReferenceOffset() === null) {
            return $sequenceNumberSettingsTransfer;
        }

        return $sequenceNumberSettingsTransfer->setOffset($this->config->getReferenceOffset());
    }

    /**
     * @return string
     */
    protected function getSequenceNumberPrefix(): string
    {
        $sequenceNumberPrefixParts = [
            $this->storeFacade->getCurrentStore()->getName(),
        ];

        $referencePrefix = $this->config->getReferencePrefix();

        if ($referencePrefix !== null && $referencePrefix !== '') {
            $sequenceNumberPrefixParts[0] = $referencePrefix;
        }

        $referenceEnvironmentPrefix = $this->config->getReferenceEnvironmentPrefix();

        if ($referenceEnvironmentPrefix !== null && $referenceEnvironmentPrefix !== '') {
            $sequenceNumberPrefixParts[] = $this->config->getReferenceEnvironmentPrefix();
        }

        return sprintf(
            '%s%s',
            implode($this->getUniqueIdentifierSeparator(), $sequenceNumberPrefixParts),
            $this->getUniqueIdentifierSeparator()
        );
    }

    /**
     * Separator for the sequence number
     *
     * @return string
     */
    protected function getUniqueIdentifierSeparator(): string
    {
        return static::UNIQUE_IDENTIFIER_SEPARATOR;
    }
}
