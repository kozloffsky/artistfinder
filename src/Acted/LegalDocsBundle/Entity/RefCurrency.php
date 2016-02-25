<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * RefCurrency
 */
class RefCurrency
{
    /**
     * @var int
     */
    private $id;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @var int
     */
    private $currencyId;

    /**
     * @var varchar
     */
    private $isoCode;

    /**
     * @var varchar
     */
    private $symbol;


    /**
     * Set currencyId
     *
     * @param \int $currencyId
     *
     * @return RefCurrency
     */
    public function setCurrencyId(\int $currencyId)
    {
        $this->currencyId = $currencyId;

        return $this;
    }

    /**
     * Get currencyId
     *
     * @return \int
     */
    public function getCurrencyId()
    {
        return $this->currencyId;
    }

    /**
     * Set isoCode
     *
     * @param \varchar $isoCode
     *
     * @return RefCurrency
     */
    public function setIsoCode(\varchar $isoCode)
    {
        $this->isoCode = $isoCode;

        return $this;
    }

    /**
     * Get isoCode
     *
     * @return \varchar
     */
    public function getIsoCode()
    {
        return $this->isoCode;
    }

    /**
     * Set symbol
     *
     * @param \varchar $symbol
     *
     * @return RefCurrency
     */
    public function setSymbol(\varchar $symbol)
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * Get symbol
     *
     * @return \varchar
     */
    public function getSymbol()
    {
        return $this->symbol;
    }
}
