<?php
/**
 * Created by PhpStorm.
 * User: mikeoz
 * Date: 12/8/16
 * Time: 17:11
 */

namespace Acted\LegalDocsBundle\Entity;


class OrderItem
{


    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $generator;

    /**
     * @var array
     */
    private $data;

    /**
     * @var float
     */
    private $total_price;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $package;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $option;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $rate;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $price;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->package = new \Doctrine\Common\Collections\ArrayCollection();
        $this->option = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rate = new \Doctrine\Common\Collections\ArrayCollection();
        $this->price = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return OrderItem
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set id
     *
     * @param string $id
     *
     * @return OrderItem
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set generator
     *
     * @param string $generator
     *
     * @return OrderItem
     */
    public function setGenerator($generator)
    {
        $this->generator = $generator;

        return $this;
    }

    /**
     * Get generator
     *
     * @return string
     */
    public function getGenerator()
    {
        return $this->generator;
    }

    /**
     * Set data
     *
     * @param array $data
     *
     * @return OrderItem
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set totalPrice
     *
     * @param float $totalPrice
     *
     * @return OrderItem
     */
    public function setTotalPrice($totalPrice)
    {
        $this->total_price = $totalPrice;

        return $this;
    }

    /**
     * Get totalPrice
     *
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->total_price;
    }

    /**
     * Add package
     *
     * @param \Acted\LegalDocsBundle\Entity\Pachage $package
     *
     * @return OrderItem
     */
    public function addPackage(\Acted\LegalDocsBundle\Entity\Package $package)
    {
        $this->package[] = $package;

        return $this;
    }

    /**
     * Remove package
     *
     * @param \Acted\LegalDocsBundle\Entity\Pachage $package
     */
    public function removePackage(\Acted\LegalDocsBundle\Entity\Package $package)
    {
        $this->package->removeElement($package);
    }

    /**
     * Get package
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * Add option
     *
     * @param \Acted\LegalDocsBundle\Entity\Option $option
     *
     * @return OrderItem
     */
    public function addOption(\Acted\LegalDocsBundle\Entity\Option $option)
    {
        $this->option[] = $option;

        return $this;
    }

    /**
     * Remove option
     *
     * @param \Acted\LegalDocsBundle\Entity\Option $option
     */
    public function removeOption(\Acted\LegalDocsBundle\Entity\Option $option)
    {
        $this->option->removeElement($option);
    }

    /**
     * Get option
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * Add rate
     *
     * @param \Acted\LegalDocsBundle\Entity\Rate $rate
     *
     * @return OrderItem
     */
    public function addRate(\Acted\LegalDocsBundle\Entity\Rate $rate)
    {
        $this->rate[] = $rate;

        return $this;
    }

    /**
     * Remove rate
     *
     * @param \Acted\LegalDocsBundle\Entity\Rate $rate
     */
    public function removeRate(\Acted\LegalDocsBundle\Entity\Rate $rate)
    {
        $this->rate->removeElement($rate);
    }

    /**
     * Get rate
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Add price
     *
     * @param \Acted\LegalDocsBundle\Entity\Price $price
     *
     * @return OrderItem
     */
    public function addPrice(\Acted\LegalDocsBundle\Entity\Price $price)
    {
        $this->price[] = $price;

        return $this;
    }

    /**
     * Remove price
     *
     * @param \Acted\LegalDocsBundle\Entity\Price $price
     */
    public function removePrice(\Acted\LegalDocsBundle\Entity\Price $price)
    {
        $this->price->removeElement($price);
    }

    /**
     * Get price
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrice()
    {
        return $this->price;
    }
}
