<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * PerformanceMedia
 */
class PerformanceMedia
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $mediaId;

    /**
     * @var integer
     */
    private $performanceId;


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
     * Set mediaId
     *
     * @param integer $mediaId
     *
     * @return PerformanceMedia
     */
    public function setMediaId($mediaId)
    {
        $this->mediaId = $mediaId;

        return $this;
    }

    /**
     * Get mediaId
     *
     * @return integer
     */
    public function getMediaId()
    {
        return $this->mediaId;
    }

    /**
     * Set performanceId
     *
     * @param integer $performanceId
     *
     * @return PerformanceMedia
     */
    public function setPerformanceId($performanceId)
    {
        $this->performanceId = $performanceId;

        return $this;
    }

    /**
     * Get performanceId
     *
     * @return integer
     */
    public function getPerformanceId()
    {
        return $this->performanceId;
    }
}
