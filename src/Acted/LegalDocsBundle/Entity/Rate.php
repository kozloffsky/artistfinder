<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * Rate
 */
class Rate
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $deletedTime;

    /**
     * @var \Acted\LegalDocsBundle\Entity\Price
     */
    private $price;

    /**
     * @var \Acted\LegalDocsBundle\Entity\Option
     */
    private $option;

    /**
     * Set price
     *
     * @param \Acted\LegalDocsBundle\Entity\Price $price
     *
     * @return Rate
     */
    public function setPrice(\Acted\LegalDocsBundle\Entity\Price $price = null)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return \Acted\LegalDocsBundle\Entity\Price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set option
     *
     * @param \Acted\LegalDocsBundle\Entity\Option $option
     *
     * @return Rate
     */
    public function setOption(\Acted\LegalDocsBundle\Entity\Option $option = null)
    {
        $this->option = $option;

        return $this;
    }

    /**
     * Get option
     *
     * @return \Acted\LegalDocsBundle\Entity\Option
     */
    public function getOption()
    {
        return $this->option;
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
     * Set deletedTime
     *
     * @param \DateTime $deletedTime
     *
     * @return Rate
     */
    public function setDeletedTime($deletedTime)
    {
        $this->deletedTime = $deletedTime;

        return $this;
    }

    /**
     * Get deletedTime
     *
     * @return \DateTime
     */
    public function getDeletedTime()
    {
        return $this->deletedTime;
    }
    /**
     * @var boolean
     */
    private $isSelected = false;


    /**
     * Set isSelected
     *
     * @param boolean $isSelected
     *
     * @return Rate
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
}
