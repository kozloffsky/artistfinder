<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * DocumentRequestQuotation
 */
class DocumentRequestQuotation
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $path;

    /**
     * @var \Acted\LegalDocsBundle\Entity\RequestQuotation
     */
    private $requestQuotation;


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
     * Set path
     *
     * @param string $path
     *
     * @return DocumentRequestQuotation
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set requestQuotation
     *
     * @param \Acted\LegalDocsBundle\Entity\RequestQuotation $requestQuotation
     *
     * @return DocumentRequestQuotation
     */
    public function setRequestQuotation(\Acted\LegalDocsBundle\Entity\RequestQuotation $requestQuotation = null)
    {
        $this->requestQuotation = $requestQuotation;

        return $this;
    }

    /**
     * Get requestQuotation
     *
     * @return \Acted\LegalDocsBundle\Entity\RequestQuotation
     */
    public function getRequestQuotation()
    {
        return $this->requestQuotation;
    }
}
