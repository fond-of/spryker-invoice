<?php

namespace FondOfSpryker\Zed\Invoice\Dependency\Facade;

class InvoiceToCountryBridge implements InvoiceToCountryInterface
{
    /**
     * @var \FondOfSpryker\Zed\Country\Business\CountryFacadeInterface
     */
    protected $countryFacade;

    /**
     * @param \Spryker\Zed\Country\Business\CountryFacadeInterface $countryFacade
     */
    public function __construct($countryFacade)
    {
        $this->countryFacade = $countryFacade;
    }

    /**
     * @param string $iso2Code
     *
     * @return \Generated\Shared\Transfer\CountryTransfer
     */
    public function getCountryByIso2Code($iso2Code)
    {
        return $this->countryFacade->getCountryByIso2Code($iso2Code);
    }

    /**
     * @param string $iso2Code
     *
     * @return int
     */
    public function getIdRegionByIso2Code($iso2Code)
    {
        return $this->countryFacade->getIdRegionByIso2Code($iso2Code);
    }
}
