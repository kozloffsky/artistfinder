<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * Media
 */
class Media
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $mediaType;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $link;

    /**
     * @var integer
     */
    private $mediaSize;


    /**
     * @var boolean
     */
    private $active;


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
     * Set mediaType
     *
     * @param string $mediaType
     *
     * @return Media
     */
    public function setMediaType($mediaType)
    {
        $this->mediaType = $mediaType;

        return $this;
    }

    /**
     * Get mediaType
     *
     * @return string
     */
    public function getMediaType()
    {
        return $this->mediaType;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Media
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Media
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->rel2abs($this->link);
    }

    public function getVideoId()
    {
        if($this->mediaType != 'video' || (!preg_match('/\/(\d+)$/is', $this->link, $matches)) || empty($matches[1])) {
            return null;
        }
        return $matches[1];
    }

    /**
     * Set mediaSize
     *
     * @param integer $mediaSize
     *
     * @return Media
     */
    public function setMediaSize($mediaSize)
    {
        $this->mediaSize = $mediaSize;

        return $this;
    }

    /**
     * Get mediaSize
     *
     * @return integer
     */
    public function getMediaSize()
    {
        return $this->mediaSize;
    }


    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Media
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }
    /**
     * @var string
     */
    private $thumbnail;


    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     *
     * @return Media
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $performances;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->performances = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add performance
     *
     * @param \Acted\LegalDocsBundle\Entity\Performance $performance
     *
     * @return Media
     */
    public function addPerformance(\Acted\LegalDocsBundle\Entity\Performance $performance)
    {
        $this->performances[] = $performance;

        return $this;
    }


    /**
     * Remove performance
     *
     * @param \Acted\LegalDocsBundle\Entity\Performance $performance
     */
    public function removePerformance(\Acted\LegalDocsBundle\Entity\Performance $performance)
    {
        $this->performances->removeElement($performance);
    }

    /**
     * Get performances
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPerformances()
    {
        return $this->performances;
    }
    /**
     * @var integer
     */
    private $position = 1;


    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Media
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $profiles;


    /**
     * Add profile
     *
     * @param \Acted\LegalDocsBundle\Entity\Profile $profile
     *
     * @return Media
     */
    public function addProfile(\Acted\LegalDocsBundle\Entity\Profile $profile)
    {
        $this->profiles[] = $profile;

        return $this;
    }

    /**
     * Remove profile
     *
     * @param \Acted\LegalDocsBundle\Entity\Profile $profile
     */
    public function removeProfile(\Acted\LegalDocsBundle\Entity\Profile $profile)
    {
        $this->profiles->removeElement($profile);
    }

    /**
     * Get profiles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProfiles()
    {
        return $this->profiles;
    }

    protected  function rel2abs($link)
    {
        if(strpos($link, 'http') === 0){
            return $link;
        }
        return '/'.ltrim($link, '/');
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $homespotlights;


    /**
     * Add homespotlight
     *
     * @param \Acted\LegalDocsBundle\Entity\Homespotlight $homespotlight
     *
     * @return Media
     */
    public function addHomespotlight(\Acted\LegalDocsBundle\Entity\Homespotlight $homespotlight)
    {
        $this->homespotlights[] = $homespotlight;

        return $this;
    }

    /**
     * Remove homespotlight
     *
     * @param \Acted\LegalDocsBundle\Entity\Homespotlight $homespotlight
     */
    public function removeHomespotlight(\Acted\LegalDocsBundle\Entity\Homespotlight $homespotlight)
    {
        $this->homespotlights->removeElement($homespotlight);
    }

    /**
     * Get homespotlights
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHomespotlights()
    {
        return $this->homespotlights;
    }
}
