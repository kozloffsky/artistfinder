<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * PerformanceRequestQuotation
 */
class PerformanceRequestQuotation
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
     * @var \Acted\LegalDocsBundle\Entity\Performance
     */
    private $performance;


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
     * @return PerformanceRequestQuotation
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
     * @return PerformanceRequestQuotation
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
     * Set performance
     *
     * @param \Acted\LegalDocsBundle\Entity\Performance $performance
     *
     * @return PerformanceRequestQuotation
     */
    public function setPerformance(\Acted\LegalDocsBundle\Entity\Performance $performance = null)
    {
        $this->performance = $performance;

        return $this;
    }

    /**
     * Get performance
     *
     * @return \Acted\LegalDocsBundle\Entity\Performance
     */
    public function getPerformance()
    {
        return $this->performance;
    }
}
