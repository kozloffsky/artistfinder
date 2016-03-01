<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * RefCurrency
 */
class RefCurrency
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $isoCode;

    /**
     * @var string
     */
    private $symbol;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set isoCode
     *
     * @param string $isoCode
     *
     * @return RefCurrency
     */
    public function setIsoCode($isoCode)
    {
        $this->isoCode = $isoCode;

        return $this;
    }

    /**
     * Get isoCode
     *
     * @return string
     */
    public function getIsoCode()
    {
        return $this->isoCode;
    }

    /**
     * Set symbol
     *
     * @param string $symbol
     *
     * @return RefCurrency
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * Get symbol
     *
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }
}
