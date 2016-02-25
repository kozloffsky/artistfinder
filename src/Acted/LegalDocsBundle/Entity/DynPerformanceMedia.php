<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * DynPerformanceMedia
 */
class DynPerformanceMedia
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
     * @var integer
     */
    private $mediaId;

    /**
     * @var integer
     */
    private $performanceId;


    /**
     * Set mediaId
     *
     * @param integer $mediaId
     *
     * @return DynPerformanceMedia
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
     * @return DynPerformanceMedia
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
