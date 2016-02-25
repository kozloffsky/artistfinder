<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * DynProfileMedia
 */
class DynProfileMedia
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
    private $profileId;


    /**
     * Set mediaId
     *
     * @param integer $mediaId
     *
     * @return DynProfileMedia
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
     * Set profileId
     *
     * @param integer $profileId
     *
     * @return DynProfileMedia
     */
    public function setProfileId($profileId)
    {
        $this->profileId = $profileId;

        return $this;
    }

    /**
     * Get profileId
     *
     * @return integer
     */
    public function getProfileId()
    {
        return $this->profileId;
    }
}
