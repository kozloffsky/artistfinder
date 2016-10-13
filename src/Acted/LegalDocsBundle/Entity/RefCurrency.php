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
     * @var \Acted\LegalDocsBundle\Entity\RefCountry
     */
    private $refCountry;


    /**
     * Set refCountry
     *
     * @param \Acted\LegalDocsBundle\Entity\RefCountry $refCountry
     *
     * @return RefCurrency
     */
    public function setRefCountry(\Acted\LegalDocsBundle\Entity\RefCountry $refCountry = null)
    {
        $this->refCountry = $refCountry;

        return $this;
    }

    /**
     * Get refCountry
     *
     * @return \Acted\LegalDocsBundle\Entity\RefCountry
     */
    public function getRefCountry()
    {
        return $this->refCountry;
    }


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
