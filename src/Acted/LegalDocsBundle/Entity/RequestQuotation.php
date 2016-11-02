<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * RequestQuotation
 */
class RequestQuotation
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;
    
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $status = false;

    /**
     * @var \Acted\LegalDocsBundle\Entity\Event
     */
    private $event;

    /**
     * @var \Acted\LegalDocsBundle\Entity\PaymentTermRequestQuotation
     */
    private $paymentTermRequestQuotation;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $performanceRequestQuotations;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $serviceRequestQuotations;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $documentRequestQuotations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->performanceRequestQuotations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->serviceRequestQuotations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->documentRequestQuotations = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set status
     *
     * @param boolean $status
     *
     * @return RequestQuotation
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set event
     *
     * @param \Acted\LegalDocsBundle\Entity\Event $event
     *
     * @return RequestQuotation
     */
    public function setEvent(\Acted\LegalDocsBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \Acted\LegalDocsBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set paymentTermRequestQuotation
     *
     * @param \Acted\LegalDocsBundle\Entity\PaymentTermRequestQuotation $paymentTermRequestQuotation
     *
     * @return RequestQuotation
     */
    public function setPaymentTermRequestQuotation(\Acted\LegalDocsBundle\Entity\PaymentTermRequestQuotation $paymentTermRequestQuotation = null)
    {
        $this->paymentTermRequestQuotation = $paymentTermRequestQuotation;

        return $this;
    }

    /**
     * Get paymentTermRequestQuotation
     *
     * @return \Acted\LegalDocsBundle\Entity\PaymentTermRequestQuotation
     */
    public function getPaymentTermRequestQuotation()
    {
        return $this->paymentTermRequestQuotation;
    }

    /**
     * Add performanceRequestQuotation
     *
     * @param \Acted\LegalDocsBundle\Entity\PerformanceRequestQuotation $performanceRequestQuotation
     *
     * @return RequestQuotation
     */
    public function addPerformanceRequestQuotation(\Acted\LegalDocsBundle\Entity\PerformanceRequestQuotation $performanceRequestQuotation)
    {
        $this->performanceRequestQuotations[] = $performanceRequestQuotation;

        return $this;
    }

    /**
     * Remove performanceRequestQuotation
     *
     * @param \Acted\LegalDocsBundle\Entity\PerformanceRequestQuotation $performanceRequestQuotation
     */
    public function removePerformanceRequestQuotation(\Acted\LegalDocsBundle\Entity\PerformanceRequestQuotation $performanceRequestQuotation)
    {
        $this->performanceRequestQuotations->removeElement($performanceRequestQuotation);
    }

    /**
     * Get performanceRequestQuotations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPerformanceRequestQuotations()
    {
        return $this->performanceRequestQuotations;
    }

    /**
     * Add serviceRequestQuotation
     *
     * @param \Acted\LegalDocsBundle\Entity\ServiceRequestQuotation $serviceRequestQuotation
     *
     * @return RequestQuotation
     */
    public function addServiceRequestQuotation(\Acted\LegalDocsBundle\Entity\ServiceRequestQuotation $serviceRequestQuotation)
    {
        $this->serviceRequestQuotations[] = $serviceRequestQuotation;

        return $this;
    }

    /**
     * Remove serviceRequestQuotation
     *
     * @param \Acted\LegalDocsBundle\Entity\ServiceRequestQuotation $serviceRequestQuotation
     */
    public function removeServiceRequestQuotation(\Acted\LegalDocsBundle\Entity\ServiceRequestQuotation $serviceRequestQuotation)
    {
        $this->serviceRequestQuotations->removeElement($serviceRequestQuotation);
    }

    /**
     * Get serviceRequestQuotations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServiceRequestQuotations()
    {
        return $this->serviceRequestQuotations;
    }

    /**
     * Add documentRequestQuotation
     *
     * @param \Acted\LegalDocsBundle\Entity\DocumentRequestQuotation $documentRequestQuotation
     *
     * @return RequestQuotation
     */
    public function addDocumentRequestQuotation(\Acted\LegalDocsBundle\Entity\DocumentRequestQuotation $documentRequestQuotation)
    {
        $this->documentRequestQuotations[] = $documentRequestQuotation;

        return $this;
    }

    /**
     * Remove documentRequestQuotation
     *
     * @param \Acted\LegalDocsBundle\Entity\DocumentRequestQuotation $documentRequestQuotation
     */
    public function removeDocumentRequestQuotation(\Acted\LegalDocsBundle\Entity\DocumentRequestQuotation $documentRequestQuotation)
    {
        $this->documentRequestQuotations->removeElement($documentRequestQuotation);
    }

    /**
     * Get documentRequestQuotations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocumentRequestQuotations()
    {
        return $this->documentRequestQuotations;
    }
}
