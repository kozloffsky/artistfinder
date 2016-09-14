<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * PricePackage
 */
class PricePackage
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $priceId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $deletedTime;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $priceOptions;

    /**
     * @var \Acted\LegalDocsBundle\Entity\Price
     */
    private $price;

    /**
     * Set price
     *
     * @param \Acted\LegalDocsBundle\Entity\Price $price
     *
     * @return PricePackage
     */
    public function setPrice(\Acted\LegalDocsBundle\Entity\Price $price)
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
     * Add priceOption
     *
     * @param \Acted\LegalDocsBundle\Entity\PriceOption $priceOption
     *
     * @return PricePackage
     */
    public function addPriceOption(\Acted\LegalDocsBundle\Entity\PriceOption $priceOption)
    {
        $this->priceOptions[] = $priceOption;

        return $this;
    }

    /**
     * Remove priceOption
     *
     * @param \Acted\LegalDocsBundle\Entity\PriceOption $priceOption
     */
    public function removePriceOption(\Acted\LegalDocsBundle\Entity\PriceOption $priceOption)
    {
        $this->priceOptions->removeElement($priceOption);
    }

    /**
     * Get priceOptions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPriceOptions()
    {
        return $this->priceOptions;
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
     * Set priceId
     *
     * @param integer $priceId
     *
     * @return PricePackage
     */
    public function setPriceId($priceId)
    {
        $this->priceId = $priceId;

        return $this;
    }

    /**
     * Get priceId
     *
     * @return integer
     */
    public function getPriceId()
    {
        return $this->priceId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return PricePackage
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
     * Set deletedTime
     *
     * @param \DateTime $deletedTime
     *
     * @return PricePackage
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
}
