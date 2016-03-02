<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * ProfileMedia
 */
class ProfileMedia
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
    private $profileId;


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
     * @return ProfileMedia
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
     * @return ProfileMedia
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
