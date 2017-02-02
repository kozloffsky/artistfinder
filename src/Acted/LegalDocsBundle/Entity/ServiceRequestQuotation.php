<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * ServiceRequestQuotation
 */
class ServiceRequestQuotation
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $isSelected = false;

    /**
     * @var \Acted\LegalDocsBundle\Entity\RequestQuotation
     */
    private $requestQuotation;

    /**
     * @var \Acted\LegalDocsBundle\Entity\Service
     */
    private $service;


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
     * Set isSelected
     *
     * @param boolean $isSelected
     *
     * @return ServiceRequestQuotation
     */
    public function setIsSelected($isSelected)
    {
        $this->isSelected = $isSelected;

        return $this;
    }

    /**
     * Get isSelected
     *
     * @return boolean
     */
    public function getIsSelected()
    {
        return $this->isSelected;
    }

    /**
     * Set requestQuotation
     *
     * @param \Acted\LegalDocsBundle\Entity\RequestQuotation $requestQuotation
     *
     * @return ServiceRequestQuotation
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

    /**
     * Set service
     *
     * @param \Acted\LegalDocsBundle\Entity\Service $service
     *
     * @return ServiceRequestQuotation
     */
    public function setService(\Acted\LegalDocsBundle\Entity\Service $service = null)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \Acted\LegalDocsBundle\Entity\Service
     */
    public function getService()
    {
        return $this->service;
    }
}
